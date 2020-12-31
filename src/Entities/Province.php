<?php

namespace LocalStateNepal\Entities;

class Province
{
    protected $provinces;

    public function __construct($provinces)
    {
        $this->provinces = $provinces;
    }
}