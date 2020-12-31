<?php

namespace LocalStateNepal\Entities;

/**
 * Class District
 * @package LocalStateNepal\Entities
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