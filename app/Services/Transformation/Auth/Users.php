<?php

namespace App\Services\Transformation\Auth;

class Users
{
	/**
     * Get Ayana Auth Session Transformation
     * @param $data
     * @return array
     */
    public function getAuthSessionTransform($data)
    {
        if(!is_array($data) || empty($data))
            return array();

        return $this->setAuthSessionTransform($data);
    }

    /**
     * Set Auth Session Transformation
     * @param $data
     * @return array
     */
    protected function setAuthSessionTransform($data)
    {
        $dataTransform['user_id']               = isset($data['id']) ? $data['id'] : '';
        $dataTransform['name']                  = isset($data['name']) ? $data['name'] : '';
        $dataTransform['email']                 = isset($data['email']) ? $data['email'] : '';
        $dataTransform['user_privilage']        = $this->setUserRole($data['role']);
        $dataTransform['user_menu']             = $this->setMenuUser($data['user_menu']);
        $dataTransform['user_location']        = $this->setUserLocation($data['location']);
        
        return $dataTransform;
    }

    /**
     * Set Auth Role Transformation
     * @param $data
     * @return array
     */

    protected function setUserRole($data)
    {
        $dataTransform = array_map(function($data) {
            return [
                'role_id'   => isset($data['privilage']['id']) ? $data['privilage']['id'] : '',
                'role_name' => isset($data['privilage']['name']) ? $data['privilage']['name'] : '',
                'role_description' => isset($data['privilage']['description']) ? $data['privilage']['description'] : '',
            ];
        },$data);
        
        return $dataTransform;
    }

    /**
     * Set Auth Menu Access Transformation
     * @param $data
     * @return array
     */

    protected function setMenuUser($data)
    {
        $dataTransform = array_map(function($data) {
            return [
                'user_id'   => isset($data['user_id'])? $data['user_id'] : '',
                'menu_id'   => isset($data['menu_id'])? $data['menu_id'] : '',
                'slug'      => isset($data['menu']['slug'])? $data['menu']['slug'] : '',
                'url'       => isset($data['menu']['url'])? $data['menu']['url'] : '',

            ];
        }, $data);

        return $dataTransform;
    }

    /**
     * Set Auth Location Access Transformation
     * @param $data
     * @return array
     */

    protected function setUserLocation($data)
    {
        $dataTransform['name'] = isset($data['name']) ? $data['name'] : '';
        $dataTransform['slug'] = isset($data['slug']) ? $data['slug'] : '';

        return $dataTransform;
    }

}