<?php

namespace Sagautam5\LocalStateNepal\Entities;

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
     * @param $districts
     */
    public function __construct($districts)
    {
        $this->districts = $districts;
    }
}