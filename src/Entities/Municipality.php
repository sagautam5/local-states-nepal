<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Helpers\Helper;
use Sagautam5\LocalStateNepal\Loaders\MunicipalitiesLoader;

/**
 * Class Municipality
 * @package Sagautam5\LocalStateNepal\Entities
 */
class Municipality
{
    /**
     * @var
     */
    private $municipalities;

    /**
     * @var string
     */
    private $lang;

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
            $this->municipalities = $loader->municipalites();

            $category = new Category($this->lang);
            $categories = $category->allCategories();

            $this->municipalities = array_map(function ($item) use ($categories){
                $item = (array)$item;
                $item['name'] = $item['name'].' '.$categories[$item['category_id']-1]->name;
                return (object)$item;
            }, $this->municipalities);

        }catch (LoadingException $exception){
            throw $exception;
        }
    }

    /**
     * Get Language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->lang;
    }

    /**
     * Get List of All Municipalities
     * @return mixed|null
     */
    public function allMunicipalities()
    {
        return $this->municipalities;
    }

    /**
     * Get Municipalities By District ID
     *
     * @param $districtId
     * @return array|mixed|null
     */
    public function getMunicipalitiesByDistrict($districtId)
    {
        return array_filter($this->municipalities, function ($item) use ($districtId) {
            return ($item->district_id == $districtId);
        });
    }

    /**
     * Find Municipality By ID
     *
     * @param $id
     * @return false|int|string
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->municipalities, 'id')));

        return is_int($key) ? $this->municipalities[$key]:null;
    }

    /**
     * Get Province With Largest Area
     * @return mixed
     */
    public function largest()
    {
        $area = array_column($this->municipalities, 'area_sq_km');

        if($this->lang == 'np'){
            $area = array_map(function ($item){
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->municipalities[array_search(max($area), $area)];
    }

    /**
     * Get Province With Smallest Area
     *
     * @return mixed
     */
    public function smallest()
    {
        $area = array_column($this->municipalities, 'area_sq_km');

        if($this->lang == 'np'){
            $area = array_map(function ($item){
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->municipalities[array_search(min($area), $area)];
    }

    /**
     * Get Wards of Municipality
     *
     * @param $id
     * @return array
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
}