<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
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
    protected $municipalities;

    /**
     * Municipality constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $loader = new MunicipalitiesLoader($lang);
            $this->municipalities = $loader->municipalites();
        }catch (LoadingException $exception){
            throw $exception;
        }
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
        return $this->municipalities[array_search(min($area), $area)];
    }
}