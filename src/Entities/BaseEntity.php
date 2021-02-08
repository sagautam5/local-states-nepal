<?php


namespace Sagautam5\LocalStateNepal\Entities;


abstract class BaseEntity
{
    /**
     * @var
     */
    protected $items;

    /**
     * @var
     */
    protected $keys;

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
        return  array_values(array_filter($data, function ($item) use ($key, $value, $exact) {
            return ($exact ? ($item->$key == $value ? true:false) :(is_int(strpos($item->$key, $value)) ? true:false));
        }));
    }

    /**
     * @return mixed
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Recursive Search Data
     *
     * @param $params
     * @param array $items
     * @return array|mixed
     */
    public function recursiveSearch($params, $items = [])
    {
        $items = $items ? $items : $this->items;

        $param = count($params) ? array_pop($params):null;

        $items = $param ? $this->filter($param['key'], $param['value'], $items, $param['exact']):$items;

        return ($param && $items) ? $this->recursiveSearch($params, $items):$items;
    }

    /**
     * Sort items by column
     *
     * @param string $key
     * @param int $order
     * @return mixed
     */
    public function sortBy($key = 'name', $order = SORT_ASC)
    {
        $keys = array_column($this->items, $key);

        $items = $this->items;
        array_multisort($keys, $order, $items);

        return $items;
    }
}