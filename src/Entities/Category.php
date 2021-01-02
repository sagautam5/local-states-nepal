<?php

namespace Sagautam5\LocalStateNepal\Entities;

/**
 * Class Category
 * @package Sagautam5\LocalStateNepal\Entities
 */
class Category
{
    /**
     * @var
     */
    protected $categories;

    /**
     * Category constructor.
     * @param $categories
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
    }
}