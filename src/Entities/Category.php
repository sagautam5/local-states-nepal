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
     * @var
     */
    private $categories;

    /**
     * @var string
     */
    private $lang;

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
            $this->categories = $loader->categories();
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
        return $this->categories;
    }

    /**
     * Find category by id
     *
     * @param $id
     * @return false|int|string
     */
    public function find($id)
    {
        $key = (array_search($id, array_column($this->categories, 'id')));

        return is_int($key) ? $this->categories[$key]:null;
    }

    /**
     * Find category by short code
     *
     * @param $short_code
     * @return |null
     */
    public function findByShortCode($short_code)
    {
        $key = (array_search($short_code, array_column($this->categories, 'short_code')));

        return is_int($key) ? $this->categories[$key]:null;
    }

    /**
     * Search Categories
     *
     * @param $key
     * @param $value
     * @param bool $exact
     * @return array
     */
    public function search($key, $value, $exact = false)
    {
        $categories = $this->allCategories();

        return $this->filter($key, $value, $categories, $exact);
    }
}