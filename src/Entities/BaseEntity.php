<?php


namespace Sagautam5\LocalStateNepal\Entities;


class BaseEntity
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
     * Sort Data by Key
     *
     * @param $key
     * @param array $items
     * @param string $direction
     *
     * @return array
     */
    public function sortBy($key, $direction = 'ASC', $items = [] )
    {
        $items = ($items ? $items: $this->items);

        uasort($items, function ($first, $second) use ($key, $direction) {
            $firstValue = $first->$key;
            $secondValue = $second->$key;
            if ($firstValue == $secondValue) return 0;
            elseif (($direction == 'DSC' ? $firstValue < $secondValue : $firstValue > $secondValue)) return 1;
            else return -1;
        });

        return $items;
    }
}