<?php


namespace Sagautam5\LocalStateNepal\Entities;


class BaseEntity
{
    /**
     * Filter data by key value pair
     *
     * @param $key
     * @param $value
     * @param $data
     * @param bool $exact
     * @return array
     */
    protected function filter($key, $value, $data, $exact = false)
    {
        return  array_filter($data, function ($item) use ($key, $value, $exact) {
            return $exact ? ($item->$key == $value ? true:false) :(is_int(strpos($item->$key, $value)) ? true:false);
        });
    }
}