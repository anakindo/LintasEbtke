<?php

namespace App\Services\Transformation\Cms;

use LaravelLocalization;
use DataHelper;
use Carbon\Carbon;

class EnergyConservation
{
	/**
     * @param $data
     * @return array
     */
    public function getEnergyConservationCmsTransform($data)
    {
        if(!is_array($data) || empty($data))
            return array();

        return $this->setEnergyConservationCmsTransform($data);
    }

    /**
     * Get Data Transformation For Insert Translation
     * @param $data
     * @param $lastInsertId
     * @return array|void
     */

    public function getDataTranslation($data, $lastInsertId, $isEditMode)
    {
        if(!is_array($data) || empty($data))
            return array();

        return $this->setDataTranslation($data, $lastInsertId, $isEditMode);
    }

    /**
     * Get Maps Data Transformation For Insert Translation
     * @param $data
     * @param $lastInsertId
     * @return array|void
     */

    public function getMapsDataTranslation($data, $lastInsertId, $isEditMode) 
    {
        if(!is_array($data) || empty($data))
            return array();

        return $this->setMapsDataTranslation($data, $lastInsertId, $isEditMode);
    }

    /**
     * Get Data Transformation For Edit
     * @param $data
     * @param $lastInsertId
     * @return array|void
     */
    public function getSingleForEditEnergyConservationTransform($data)
    {
        if(!is_array($data) || empty($data))
            return array();

        return $this->setSingleForEditEnergyConservationTransform($data);
    }

    /**
     * @param $data
     * @return array
     */
    protected function setEnergyConservationCmsTransform($data)
    {
        

        $dataTransform = array_map(function($data) {

            return [
                
                'id'            => isset($data['id']) ? $data['id'] : '',
                'title'         => isset($data['translation']['title']) ? $data['translation']['title'] : '',
                'is_active'     => isset($data['is_active']) ? $data['is_active'] : false,
                'thumbnail_url' => isset($data['thumbnail']) ? asset(ENERGY_CONSERVATION_DIRECTORY.rawurlencode($data['thumbnail'])) : '',
            ];
        },$data);
        
        return $dataTransform;
    }

    /**
     * Set Data Transformation For Insert Translation
     * @param $data
     * @param $lastInsertId
     * @return array|void
     */
    protected function setDataTranslation($data, $lastInsertId, $isEditMode)
    {
        try {
            $supportedLanguage = LaravelLocalization::getSupportedLanguagesKeys();

            $finalData = [];
            foreach ($supportedLanguage as $key => $value) {
                $finalData[] = [
                    "locale"                => $value,
                    "title"                 => isset($data['title'][$value]) ? $data['title'][$value] : '',
                    "slug"                  => isset($data['slug'][$value]) ? str_slug($data['slug'][$value]) : '',
                    "introduction"          => isset($data['introduction'][$value]) ? $data['introduction'][$value] : '',
                    "description"           => isset($data['description'][$value]) ? $data['description'][$value] : '',
                    "meta_title"            => isset($data['meta_title'][$value]) ? $data['meta_title'][$value] : '',
                    "meta_keyword"          => isset($data['meta_keyword'][$value]) ? $data['meta_keyword'][$value] : '',
                    "meta_description"      => isset($data['meta_description'][$value]) ? $data['meta_description'][$value] : '',
                    "energy_conservation_id"=> $lastInsertId,
                    "created_at"            => mysqlDateTimeFormat(),
                    "updated_at"            => mysqlDateTimeFormat(),
                ];
            }

            return $finalData;
        } catch (\Exception $e) {
            return [];
        }
    }


    /**
     * Set Maps Data Transformation For Insert
     * @param $data
     * @param $lastInsertId
     * @return array|void
     */
    protected function setMapsDataTranslation($data, $lastInsertId, $isEditMode)
    {
        try {
            
            $finalData = [];
            foreach ($data as $key => $value) {

                $finalData[] = [
                    "provinsi_id" => isset($data[$key]['provinsi_id']) ? $data[$key]['provinsi_id'] : '',
                    "maps_category_id" => isset($data[$key]['maps_category_id']) ? $data[$key]['maps_category_id'] : '',
                    
                    "energy_conservation_id" => $lastInsertId,
                    "created_at" => mysqlDateTimeFormat(),
                    "created_by" => DataHelper::userId(),
                    "updated_at" => mysqlDateTimeFormat(),
                ];
            }
            
            return $finalData;

        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Set Data For Edit
     * @param $data
     */

    protected function setSingleForEditEnergyConservationTransform($data)
    {
        $dataTransform = $this->setTranslationForEditData($data['translations']);
        $dataTransform['id'] = isset($data['id']) ? $data['id'] : '';
        $dataTransform['thumbnail_url'] = isset($data['thumbnail']) ? asset(ENERGY_CONSERVATION_DIRECTORY.rawurlencode($data['thumbnail'])) : [];
        $dataTransform['maps_data'] = $this->getMapsData($data['maps_data']);

        return $dataTransform;
    }

    /**
     * Set Translation for edit Data
     * @param $data
     */
    protected function setTranslationForEditData($data)
    {
        try {

            if(!is_array($data) || empty($data))
                return array();

            $returnValue = [];
            foreach ($data as $value) {
                $returnValue['title'][$value['locale']] = $value['title'];
                $returnValue['slug'][$value['locale']] = $value['slug'];
                $returnValue['introduction'][$value['locale']] = $value['introduction'];
                $returnValue['description'][$value['locale']] = $value['description'];
                $returnValue['description_maps'][$value['locale']] = $value['description_maps'];
                $returnValue['meta_title'][$value['locale']] = $value['meta_title'];
                $returnValue['meta_keyword'][$value['locale']] = $value['meta_keyword'];
                $returnValue['meta_description'][$value['locale']] = $value['meta_description'];
            }
            return $returnValue;

        } catch(\Exception $e) {
            return array();
        }
    }

    protected function getMapsData($data)
    {
        return array_map(function($data) {

            return [
                'provinsi_id' => isset($data['provinsi_id']) ? $data['provinsi_id'] : '',
                'maps_category_id' => isset($data['maps_category_id']) ? $data['maps_category_id'] : '',
            ];
        },$data);
    }
}