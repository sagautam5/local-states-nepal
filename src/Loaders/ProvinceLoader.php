<?php

namespace Sagautam5\LocalStateNepal\Loaders;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

/**
 * Class ProvinceLoader
 * @package Sagautam5\LocalStateNepal\Loaders
 */
class ProvinceLoader
{
    /**
     * @var mixed|null
     */
    protected $provinces;

    /**
     * ProvinceLoader constructor.
     * @param $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '/../../dataset/provinces/' .$file) : null;
            $this->provinces = $json ? json_decode($json):null;
        }catch (\Exception $e){
            var_dump($e->getMessage());
            throw new LoadingException('Failed to load province data from source ');
        }
    }

    /**
     * Fetch Provinces
     *
     * @return mixed|null
     */
    public function provinces()
    {
        return $this->provinces;
    }
}