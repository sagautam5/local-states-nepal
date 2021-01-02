<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
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
     * District constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $loader = new DistrictsLoader($lang);
            $this->districts = $loader->districts();
        }catch (LoadingException $exception){
            throw $exception;
        }
    }

    /**
     * Get List of All Districts
     * @return mixed|null
     */
    public function allDistricts()
    {
        return $this->districts;
    }

    /**
     * Find Province By ID
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
     * Get Province With Largest Area
     * @return mixed
     */
    public function largest()
    {
        $area = array_column($this->districts, 'area_sq_km');
        return $this->districts[array_search(max($area), $area)];
    }

    /**
     * Get Province With Smallest Area
     *
     * @return mixed
     */
    public function smallest()
    {
        $area = array_column($this->districts, 'area_sq_km');
        return $this->districts[array_search(min($area), $area)];
    }
}