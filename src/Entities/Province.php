<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Loaders\ProvinceLoader;

/**
 * Class Province
 * @package Sagautam5\LocalStateNepal\Entities
 */
class Province
{
    /**
     * @var mixed|null
     */
    private $provinces;

    /**
     * Province constructor.
     * @param $lang
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $loader = new ProvinceLoader($lang);
            $this->provinces = $loader->provinces();
        }catch (LoadingException $exception){
            throw $exception;
        }
    }

    /**
     * Get List of All Provinces
     * @return mixed|null
     */
    public function allProvinces()
    {
        return $this->provinces;
    }

    /**
     * Find Province By ID
     *
     * @param $id
     * @return false|int|string
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->provinces, 'id')));

        return is_int($key) ? $this->provinces[$key]:null;
    }

    /**
     * Get Province With Largest Area
     * @return mixed
     */
    public function largest()
    {
        $area = array_column($this->provinces, 'area_sq_km');
        return $this->provinces[array_search(max($area), $area)];
    }

    /**
     * Get Province With Smallest Area
     *
     * @return mixed
     */
    public function smallest()
    {
        $area = array_column($this->provinces, 'area_sq_km');
        return $this->provinces[array_search(min($area), $area)];
    }
}