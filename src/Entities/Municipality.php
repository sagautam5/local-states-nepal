<?php

namespace LocalStateNepal\Entities;

/**
 * Class Municipality
 * @package LocalStateNepal\Entities
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