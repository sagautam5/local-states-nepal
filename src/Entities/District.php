<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Helpers\Helper;
use Sagautam5\LocalStateNepal\Loaders\DistrictsLoader;

/**
 * Class District
 * @package Sagautam5\LocalStateNepal\Entities
 */
class District
{
    /**
     * @var
     */
    protected $districts;

    /**
     * @var string
     */
    private $lang;

    /**
     * District constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $this->lang = $lang;

            $loader = new DistrictsLoader($this->lang);
            $this->districts = $loader->districts();
        }catch (LoadingException $exception){
            throw $exception;
        }
    }

    /**
     * Get list of all districts
     *
     * @return mixed|null
     */
    public function allDistricts()
    {
        return $this->districts;
    }

    /**
     * Get districts with municipalities
     *
     * @return array
     * @throws LoadingException
     */
    public function getDistrictsWithMunicipalities()
    {
        $municipality = new Municipality($this->lang);

        $provinces = $this->allDistricts();

        return array_map(function ($districtItem) use($municipality){
            $districtItem = (array) $districtItem;
            $municipalities = $municipality->getMunicipalitiesByDistrict($districtItem['id']);
            $districtItem['municipalities'] = array_map(function ($municipalityItem) use ($municipality){
                $municipalityItem = (array) $municipalityItem;
                $municipalityItem['wards'] = $municipality->wards($municipalityItem['id']);
                return (object) $municipalityItem;
            }, $municipalities);
            return (object) $districtItem;
        },$provinces);
    }

    /**
     * Get districts by province id
     *
     * @param $provinceId
     * @return array|mixed|null
     */
    public function getDistrictsByProvince($provinceId)
    {
         return array_values(array_filter($this->districts, function ($item) use ($provinceId) {
             return ($item->province_id == $provinceId);
         }));
    }

    /**
     * Find district by id
     *
     * @param $id
     * @return false|int|string
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->districts, 'id')));

        return is_int($key) ? $this->districts[$key]:null;
    }

    /**
     * Get district with largest area
     *
     * @return mixed
     */
    public function largest()
    {
        $area = array_column($this->districts, 'area_sq_km');

        if($this->lang == 'np'){
            $area = array_map(function ($item){
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->districts[array_search(max($area), $area)];
    }

    /**
     * Get district with smallest area
     *
     * @return mixed
     */
    public function smallest()
    {
        $area = array_column($this->districts, 'area_sq_km');

        if($this->lang == 'np'){
            $area = array_map(function ($item){
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->districts[array_search(min($area), $area)];
    }

    /**
     * Search Districts
     *
     * @param $keyword
     * @return array
     */
    public function search($keyword)
    {
        $districts = $this->allDistricts();
        return array_filter($districts, function ($item) use ($keyword) {
            return is_int(strpos($item->name, $keyword)) ? true:false;
        });
    }
}