<?php

namespace Sagautam5\LocalStateNepal\Entities;

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
     * @param $municipalities
     */
    public function __construct($municipalities)
    {
        $this->municipalities = $municipalities;
    }
}