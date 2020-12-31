<?php

namespace LocalStateNepal\Entities;

/**
 * Class Category
 * @package LocalStateNepal\Entities
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