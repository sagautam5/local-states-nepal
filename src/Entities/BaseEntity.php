<?php


namespace Sagautam5\LocalStateNepal\Entities;


class BaseEntity
{
    /**
     * @var
     */
    protected $items;

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

    /**
     * Recursive Search Data
     *
     * @param $params
     * @param array $data
     * @return array|mixed
     */
    public function recursiveSearch($params, $data = [])
    {
        $data = $data ? $data : $this->items;

        $param = count($params) ? array_pop($params):null;

        $data = $param ? $this->filter($param['key'], $param['value'], $data, $param['exact']):$data;

        return $param ? $this->recursiveSearch($params, $data):$data;
    }
}