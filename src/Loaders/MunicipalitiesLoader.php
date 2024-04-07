<?php


namespace Sagautam5\LocalStateNepal\Loaders;

use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

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
     * @param string $lang
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
     * Fetch municipalities
     * @return mixed|null
     */
    public function municipalities()
    {
        return $this->municipalities;
    }
}