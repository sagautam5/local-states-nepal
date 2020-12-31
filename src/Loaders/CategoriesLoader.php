<?php


namespace LocalStateNepal\Loaders;


use LocalStateNepal\Exception\LoadingException;

/**
 * Class CategoriesLoader
 * @package LocalStateNepal\Loaders
 */
class CategoriesLoader
{
    /**
     * @var mixed|null
     */
    protected $categories;

    /**
     * CategoriesLoader constructor.
     * @param $lang
     * @throws LoadingException
     */
    public function __construct($lang)
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '../../dataset/categories/' .$file) : null;
            $this->categories = $json ? json_decode($json):null;
        }catch (\Exception $e){
            throw new LoadingException('Failed to load data from source ');
        }
    }

    /**
     * Fetch Categories
     *
     * @return mixed|null
     */
    public function categories()
    {
        return $this->categories;
    }
}