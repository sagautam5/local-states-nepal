<?php

namespace LocalStateNepal\Loaders;

use LocalStateNepal\Exception\LoadingException;

/**
 * Class ProvinceLoader
 * @package LocalStateNepal\Loaders
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
    public function __construct($lang)
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '../../dataset/provinces/' .$file) : null;
            $this->provinces = $json ? json_decode($json):null;
        }catch (\Exception $e){
            throw new LoadingException('Failed to load data from source ');
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