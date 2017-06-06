<?php

namespace App\Repositories\Implementation\Auth;

use App\Custom\RouteMenuLocation;
use App\Repositories\Contracts\Auth\Users as UserInterface;
use App\Repositories\Implementation\BaseImplementation;
use App\Models\Auth\Users as UserModel;
use App\Custom\Facades\DataHelper;
use App\Services\Transformation\Auth\Users as UserTransformation;
use Cache;
use Session;
use DB;
use Auth;
use Hash;

class Users extends BaseImplementation implements UserInterface
{

    protected $user;
    protected $userTransformation;

    function __construct(UserModel $user, UserTransformation $userTransformation)
    {

        $this->user = $user;
        $this->userTransformation = $userTransformation;
    }

	/**
     * Set Ayana Auth Session
     * Warning: this function doesn't redis cache
     * @param $params
     * @return array
     */
    public function setAuthSession($params)
    {

        $userInfo = Auth::user();

        if (empty($userInfo)) {
           return false;
        }

        $userId = !empty($userInfo) && isset($userInfo['id']) ?  $userInfo['id'] : '';

        $params = [
            'id' => $userId,
            'is_active' => true,
            'current_location_slug' => true,
        ];

        $userData = $this->user($params, 'asc', 'array', true);

        if(empty($userData))
            return false;

        $data = $this->userTransformation->getAuthSessionTransform($userData);

        Session::forget('user_info');
        Session::put('user_info', $data);

        
        return $data;
    }

    /**
     * Registered User Account
     * Warning: this function doesn't redis cache
     * @param $params
     * @return array
     */
    
    public function registered($data)
    {
        try {
            DB::beginTransaction();

            if ($this->registeredUser($data)) {
                //TODO: send mail first
                DB::commit();
                return $this->setResponse(trans('message.user_success_created'), true);
            }

            DB::rollBack();
            return $this->setResponse(trans('message.user_failed_created'), false);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->setResponse($e->getMessage(), false);
        }
    }

    /**
     * Get All User
     * Warning: this function doesn't redis cache
     * @param array $params
     * @return array
     */
    protected function user($params = array(), $orderType = 'asc', $returnType = 'array', $returnSingle = false)
    {
        $user = $this->user->with(['role','location','user_menu']);

        if(isset($params['id'])) {
            $user->userId($params['id']);
        }

        if(isset($params['is_active'])) {
            $user->isActive($params['is_active']);
        }

        if(!$user->count())
            return array();

        switch ($returnType) {
            case 'array':
                if(!$returnSingle) {
                    return $user->get()->toArray();
                } else {
                    return $user->first()->toArray();
                }
                break;
        }
    }

    /**
     * Change Password
     * @param $data
     */
    public function changePassword($data)
    {
        try {
            DB::beginTransaction();

            if ($this->changePasswordUser($data)) {
                //TODO: send mail first
                DB::commit();
                return $this->setResponse(trans('message.user_success_change_password'), true);
            }

            DB::rollBack();
            return $this->setResponse(trans('message.user_failed_change_password'), false);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->setResponse($e->getMessage(), false);
        }
    }

    /**
     * Change Password User
     * @param $data
     */
    protected function changePasswordUser($data)
    {
        $userId = Auth::id();
        
        try {
            //$matchThese = ['id' => $userId, 'password' => Hash::make($data['old_password']) ];
            //$users = UserModel::where($matchThese)->get();
            $users = UserModel::find($userId);
            if(Hash::check($data['old_password'], $users['password']))
            {
                $users['password']      = Hash::make($data['new_password']);
                $save = $users->save();
                return $save;    
            }
            else
                return false;
        } catch (Exception $e) {
            return $this->setResponse($e->getMessage(), false);
        }
    }

    /**
     * Registration User
     * @param $data
     */

    protected function registeredUser($data)
    {
        try {

            $store                       = $this->user;

            $store->name                 = isset($data['name']) ? $data['name'] : '';
            $store->email                = isset($data['email']) ? $data['email'] : '';
            $store->is_active            = false;
            $store->location_id          = "1";

            $store->password      = Hash::make($data['confirm_password']);

            $save = $store->save();

            return $save;

        } catch (\Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }

    }
}