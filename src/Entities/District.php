<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Helpers\Helper;
use Sagautam5\LocalStateNepal\Loaders\DistrictsLoader;

/**
 * Class District
 * @package Sagautam5\LocalStateNepal\Entities
 */
class District extends BaseEntity
{
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
            $this->items = $loader->districts();

            $this->keys = ['id', 'province_id', 'name', 'area_sq_km', 'website', 'headquarter'];

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
        return $this->items;
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
         return array_values(array_filter($this->items, function ($item) use ($provinceId) {
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
        $key = (array_search($id, array_column($this->items, 'id')));

        return is_int($key) ? $this->items[$key]:null;
    }

    /**
     * Get district with largest area
     *
     * @return mixed
     */
    public function largest()
    {
        $area = array_column($this->items, 'area_sq_km');

        if($this->lang == 'np'){
            $area = array_map(function ($item){
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->items[array_search(max($area), $area)];
    }

    /**
     * Get district with smallest area
     *
     * @return mixed
     */
    public function smallest()
    {
        $area = array_column($this->items, 'area_sq_km');

        if($this->lang == 'np'){
            $area = array_map(function ($item){
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->items[array_search(min($area), $area)];
    }

    /**
     * Search Districts
     *
     * @param $key
     * @param $value
     * @param bool $exact
     * @return array
     */
    public function search($key, $value, $exact = false)
    {
        $districts = $this->allDistricts();

        return $this->filter($key, $value, $districts, $exact);
    }
}