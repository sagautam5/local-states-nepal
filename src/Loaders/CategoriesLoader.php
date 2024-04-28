<?php


namespace Sagautam5\LocalStateNepal\Loaders;


use Sagautam5\LocalStateNepal\Exceptions\LoadingException;

/**
 * Class CategoriesLoader
 * @package Sagautam5\LocalStateNepal\Loaders
 */
class CategoriesLoader
{
    /**
     * @var mixed|null
     */
    protected $categories;

    /**
     * CategoriesLoader constructor.
     * @param string $lang
     * @throws LoadingException
     */
    public function __construct($lang = 'en')
    {
        try{
            $file = ($lang == 'np' ? 'np.json':($lang == 'en' ? 'en.json':''));
            $json = $file ? file_get_contents(__DIR__ . '/../../dataset/categories/' .$file) : null;
            $this->categories = $json ? json_decode($json):null;
        }catch (\Exception $e){
            throw new LoadingException('Failed to load categories data from source ');
        }
    }

    /**
     * Fetch categories
     *
     * @return mixed|null
     */
    public function categories()
    {
        return $this->categories;
    }
}