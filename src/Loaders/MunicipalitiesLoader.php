<?php


namespace Sagautam5\LocalStateNepal\Loaders;

use Sagautam5\LocalStateNepal\Exception\LoadingException;

/**
 * Class MunicipalitiesLoader
 * @package Sagautam5\LocalStateNepal\Loaders
 */
class MunicipalitiesLoader
{
    /**
     * @var mixed|null
     */
    protected $municipalities;

    /**
     * MunicipalitiesLoader constructor.
     * @param $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '/../../dataset/municipalities/' .$file) : null;
            $this->municipalities = $json ? json_decode($json):null;
        }catch (\Exception $e){
            throw new LoadingException('Failed to load municipalities data from source ');
        }
    }

    /**
     * @return mixed|null
     */
    public function municipalites()
    {
        return $this->municipalities;
    }
}