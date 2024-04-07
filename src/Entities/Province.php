<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Helpers\Helper;
use Sagautam5\LocalStateNepal\Loaders\ProvinceLoader;

/**
 * Class Province
 * @package Sagautam5\LocalStateNepal\Entities
 */
class Province extends BaseEntity
{
    /**
     * Province constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try {
            $this->lang = $lang;

            $loader = new ProvinceLoader($this->lang);
            $this->items = $loader->provinces();

            $this->keys = ['id', 'name','area_sq_km', 'website', 'headquarter'];

        } catch (LoadingException $exception) {
            throw $exception;
        }
    }

    /**
     * Get list of all provinces
     * @return array<object>
     */
    public function allProvinces()
    {
        return $this->items;
    }

    /**
     * Find province by id
     *
     * @param int $id
     * @return object|null
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->items, 'id')));

        return is_int($key) ? $this->items[$key] : null;
    }

    /**
     * Get province with largest area
     * 
     * @return object
     */
    public function largest()
    {
        $area = array_column($this->items, 'area_sq_km');

        if ($this->lang == 'np') {
            $area = array_map(function ($item) {
                return Helper::numericEnglish($item);
            }, $area);
        }

        return $this->items[array_search(max($area), $area)];
    }

    /**
     * Get province with smallest area
     *
     * @return object
     */
    public function smallest()
    {
        $area = array_column($this->items, 'area_sq_km');

        if ($this->lang == 'np') {
            $area = array_map(function ($item) {
                return Helper::numericEnglish($item);
            }, $area);
        }
        return $this->items[array_search(min($area), $area)];
    }


    /**
     * Get provinces with districts
     *
     * @return array<object>
     * @throws LoadingException
     */
    public function getProvincesWithDistricts()
    {
        $district = new District($this->lang);

        $provinces = $this->allProvinces();

        return array_map(function ($item) use ($district) {
            $item = (array)$item;
            $item['districts'] = $district->getDistrictsByProvince($item['id']);
            return (object)$item;
        }, $provinces);
    }

    /**
     * Get provinces with districts with municipalities
     *
     * @return array<object>
     * @throws LoadingException
     */
    public function getProvincesWithDistrictsWithMunicipalities()
    {
        $district = new District($this->lang);
        $municipality = new Municipality($this->lang);

        $provinces = $this->allProvinces();

        return array_map(function ($provinceItem) use ($district, $municipality) {
            $provinceItem = (array)$provinceItem;
            $provinceDistricts = $district->getDistrictsByProvince($provinceItem['id']);
            $provinceItem['districts'] = array_map(function ($districtItem) use ($municipality) {
                $districtItem = (array)$districtItem;
                $municipalities = $municipality->getMunicipalitiesByDistrict($districtItem['id']);
                $districtItem['municipalities'] = array_map(function ($municipalityItem) use ($municipality) {
                    $municipalityItem = (array)$municipalityItem;
                    $municipalityItem['wards'] = $municipality->wards($municipalityItem['id']);
                    return (object)$municipalityItem;
                }, $municipalities);

                return (object)$districtItem;
            }, $provinceDistricts);
            return (object)$provinceItem;
        }, $provinces);
    }

    /**
     * Search Provinces
     *
     * @param string $key
     * @param string $value
     * @param bool $exact
     * @return array<object>
     */
    public function search($key, $value, $exact = false)
    {
        $provinces = $this->allProvinces();

        return $this->filter($key, $value, $provinces, $exact);
    }
}