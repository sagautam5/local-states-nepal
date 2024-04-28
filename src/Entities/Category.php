<?php

namespace Sagautam5\LocalStateNepal\Entities;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;
use Sagautam5\LocalStateNepal\Loaders\CategoriesLoader;

/**
 * Class Category
 * @package Sagautam5\LocalStateNepal\Entities
 */
class Category extends BaseEntity
{
    /**
     * Category constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $this->lang = $lang;

            $loader = new CategoriesLoader($this->lang);
            $this->items = $loader->categories();

            $this->keys = ['id', 'name', 'short_code'];

        }catch (LoadingException $exception){
            throw $exception;
        }
    }

    /**
     * Get list of all categories
     *
     * @return mixed|null
     */
    public function allCategories()
    {
        return $this->items;
    }

    /**
     * Find category by id
     *
     * @param int $id
     * @return object|null
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->items, 'id')));

        return is_int($key) ? $this->items[$key]:null;
    }

    /**
     * Find category by short code
     *
     * @param string $short_code
     * @return object|null
     */
    public function findByShortCode($short_code)
    {
        $key = (array_search($short_code, array_column($this->items, 'short_code')));

        return is_int($key) ? $this->items[$key]:null;
    }

    /**
     * Search Categories
     *
     * @param string $key
     * @param string $value
     * @param bool $exact
     * @return array<object>
     */
    public function search($key, $value, $exact = false)
    {
        $categories = $this->allCategories();

        return $this->filter($key, $value, $categories, $exact);
    }
}