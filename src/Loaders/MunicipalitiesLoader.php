<?php


namespace LocalStateNepal\Loaders;

use LocalStateNepal\Exception\LoadingException;

/**
 * Class MunicipalitiesLoader
 * @package LocalStateNepal\Loaders
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
    public function __construct($lang)
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '../../dataset/municipalities/' .$file) : null;
            $this->municipalities = $json ? json_decode($json):null;
        }catch (\Exception $e){
            throw new LoadingException('Failed to load data from source ');
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