<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Helpers\Helper;
use Sagautam5\LocalStateNepal\Loaders\MunicipalitiesLoader;

/**
 * Class Municipality
 * @package Sagautam5\LocalStateNepal\Entities
 */
class Municipality extends BaseEntity
{
    /**
     * Municipality constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $this->lang = $lang;

            $loader = new MunicipalitiesLoader($this->lang);
            $this->items = $loader->municipalities();

            $category = new Category($this->lang);
            $categories = $category->allCategories();

            $this->items = array_map(function ($item) use ($categories){
                $item = (array)$item;
                $item['name'] = $item['name'].' '.$categories[$item['category_id']-1]->name;
                return (object)$item;
            }, $this->items);

            $this->keys = ['id', 'district_id', 'category_id', 'name','area_sq_km', 'website', 'wards'];

        }catch (LoadingException $exception){
            throw $exception;
        }
    }

    /**
     * Get list of all municipalities
     * @return mixed|null
     */
    public function allMunicipalities()
    {
        return $this->items;
    }

    /**
     * Get municipalities by district id
     *
     * @param int $districtId
     * @return array<object>|null
     */
    public function getMunicipalitiesByDistrict($districtId)
    {
        return array_values(array_filter($this->items, function ($item) use ($districtId) {
            return ($item->district_id == $districtId);
        }));
    }

    /**
     * Get municipalities by category id
     *
     * @param int $categoryId
     * @return array<object>
     */
    public function getMunicipalityByCategory($categoryId)
    {
        return array_values(array_filter($this->items, function ($item) use ($categoryId) {
            return ($item->category_id == $categoryId);
        }));
    }

    /**
     * Get municipalities by province
     * 
     * @param int $provinceId
     * @return array<object> 
     */
    public function getMunicipalityByProvince($provinceId)
    {
        $district = new District();
        $districts = $district->getDistrictsByProvince($provinceId);
        $municipalities = array_map(function ($item) {
            return $this->getMunicipalitiesByDistrict($item->id);
        }, $districts);

        return array_merge(...$municipalities);
    }

    /**
     * Find municipality by id
     *
     * @param int $id
     * @return object|null
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->items, 'id')));

        return is_int($key) ? $this->items[$key]:null;
    }

    /**
     * Get municipality with largest area
     *
     * @return object
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
     * Get municipality with smallest area
     *
     * @return object
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
     * Get wards of municipality
     *
     * @param int $id
     * @return array<string>
     */
    public function wards($id)
    {
        $municipality = $this->find($id);

        if($this->lang == 'np'){

            $totalWards = Helper::numericEnglish($municipality->wards);

            $wards = range(1, $totalWards);
            $wards = array_map(function ($item){
                return Helper::numericNepali($item);
            }, $wards);
        }else{
            $wards = range(1, $municipality->wards);
        }
        return $wards;
    }

    /**
     * Search Municipalities
     *
     * @param string $key
     * @param string $value
     * @param bool $exact
     * @return array<object>
     */
    public function search($key, $value, $exact = false)
    {
        $municipalities = $this->allMunicipalities();

        return $this->filter($key, $value, $municipalities, $exact);
    }
}