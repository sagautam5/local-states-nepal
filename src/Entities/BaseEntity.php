<?php

namespace Sagautam5\LocalStateNepal\Entities;

abstract class BaseEntity
{
    /**
     * @var array<object>
     */
    protected $items;

    /**
     * @var array<string>
     */
    protected $keys;

    /**
     * @var string
     */
    protected $lang;

    /**
     * Filter data by key value pair
     *
     * @param string $key
     * @param string $value
     * @param array<object> $data
     * @param bool $exact
     * @return array<object>
     */
    protected function filter($key, $value, $data, $exact = false): array
    {
        return  array_values(array_filter($data, function ($item) use ($key, $value, $exact) {
            return ($exact ? ($item->$key == $value ? true:false) :(is_int(strpos($item->$key, $value)) ? true:false));
        }));
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->lang;
    }

    /**
     * @return array<string>
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * Recursive Search Data
     *
     * @param array<mixed> $params
     * @param array<object> $items
     * @return array<object>
     */
    public function recursiveSearch($params, $items = []): array
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
     * @return array<mixed>
     */
    public function sortBy($key = 'name', $order = SORT_ASC): array
    {
        $keys = array_column($this->items, $key);

        $items = $this->items;
        array_multisort($keys, $order, $items);

        return $items;
    }
}