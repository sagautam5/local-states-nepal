<?php


namespace LocalStateNepal\Loaders;


use LocalStateNepal\Exception\LoadingException;

/**
 * Class DistrictsLoader
 * @package LocalStateNepal\Loaders
 */
class DistrictsLoader
{
    /**
     * @var mixed|null
     */
    protected $districts;

    /**
     * DistrictsLoader constructor.
     * @param $lang
     * @throws LoadingException
     */
    public function __construct($lang)
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '../../dataset/districts/' .$file) : null;
            $this->districts = $json ? json_decode($json):null;
        }catch (\Exception $e){
            throw new LoadingException('Failed to load data from source ');
        }
    }

    /**
     * Fetch Districts
     *
     * @return mixed|null
     */
    public function districts()
    {
        return $this->districts;
    }
}