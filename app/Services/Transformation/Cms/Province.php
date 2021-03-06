<?php

namespace App\Services\Transformation\Cms;

use LaravelLocalization;
use DataHelper;
use Carbon\Carbon;

class Province
{
	/**
     * @param $data
     * @return array
     */
    public function getProvinceCmsTransform($data)
    {
        if(!is_array($data) || empty($data))
            return array();

        return $this->setProvinceCmsTransform($data);
    }


    /**
     * @param $data
     * @return array
     */
    protected function setProvinceCmsTransform($data)
    {
        

        $dataTransform = array_map(function($data) {

            return [
                
                'id'            => isset($data['id']) ? $data['id'] : '',
                'title'         => isset($data['title']) ? $data['title'] : '',
                'latitude'      => isset($data['latitude']) ? $data['latitude'] : '',
                'longitude'      => isset($data['longitude']) ? $data['longitude'] : '',
                'pulau_id'      => isset($data['pulau_id']) ? $data['pulau_id'] : '',
            ];
        },$data);
        
        return $dataTransform;
    }

}