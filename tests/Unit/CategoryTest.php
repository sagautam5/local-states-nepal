<?php
namespace Sagautam5\LocalStateNepal\Test\Unit;

use PHPUnit_Framework_TestCase;
use Sagautam5\LocalStateNepal\Entities\Category;

/**
 * Class CategoryTest
 */
class CategoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var array
     */
    private $lang;

    /**
     * CategoryTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang = $_ENV['APP_LANG'];
        $this->category = new Category($this->lang);
    }

    public function test_find_category_for_range_between_1_to_4()
    {
        $correctIdSet = range(1,4);
        $incorrectIdSet = range(5,8);

        $correctStatus = true;
        foreach ($correctIdSet as $id)
        {
            $item = $this->category->find($id);

            if(!$item){
                $correctStatus= false;
            }
        }
        $this->assertTrue($correctStatus);


        $correctStatus = false;
        foreach ($incorrectIdSet as $id)
        {
            if($this->category->find($id)){
                $correctStatus= true;
            }
        }
        $this->assertFalse($correctStatus);
    }

    public function test_findBy_for_each_short_code()
    {
        $correctCodeSet = ['MC', 'SMC', 'M', 'RM'];
        $incorrectCodeSet = ['AA', 'BB', 'CC', 'DD'];

        $correctStatus = true;
        foreach ($correctCodeSet as $code)
        {
            $item = $this->category->findByShortCode($code);
            if(!$item){
                $correctStatus= false;
            }
        }
        $this->assertTrue($correctStatus);


        $correctStatus = false;
        foreach ($incorrectCodeSet as $code)
        {
            if($this->category->findByShortCode($code)){
                $correctStatus= true;
            }
        }
        $this->assertFalse($correctStatus);
    }

    public function test_allCategories_for_null_values()
    {
        $hasNull = false;
        foreach ($this->category->allCategories() as $set) {
            if ($hasNull = in_array(null, (array) $set, true)) {
                $this->fail('Category dataset can\'t have null values');
                break;
            }
        }

        $this->assertTrue(!$hasNull);
    }

    public function test_allCategories_for_count()
    {
        if(count($this->category->allCategories()) == 4){
            $this->assertTrue(true);
        }else{
            $this->fail('Only Four Categories of Local Level Exists in Nepal');
        }
    }

    public function test_search()
    {
        $categories = $this->category->allCategories();
        $keywords = ['id', 'name', 'short_code'];

        $correct = true;
        foreach ($keywords as $key){
            $dataSet = array_column($categories, $key);
            foreach ($dataSet as $item){
                if(!count($this->category->search($key,$item,true))){
                    $correct = false;
                    $this->fail('Municipality Category not found for '.$key.' => '.$item);
                }
            }
        }

        $this->assertTrue($correct);
    }

    public function test_recursiveSearch()
    {
        $params = $_ENV['APP_LANG'] == 'en' ? [
            ['key' => 'name', 'value' => 'Municipality', 'exact' => false],
            ['key' => 'short_code', 'value' => 'M', 'exact' => false]
        ]
            :
            [
                ['key' => 'name', 'value' => 'नगरपालिका', 'exact' => false],
                ['key' => 'short_code', 'value' => 'M', 'exact' => false]
            ];
        $result = $this->category->recursiveSearch($params);

        if(!$result){
            $this->fail('Not Found');
        }

        $this->assertTrue(true);
    }

    public function test_sortBy()
    {
        $keys = $this->category->getKeys();

        $orders = array(SORT_ASC, SORT_DESC);

        foreach ($orders as $order)
        {
            foreach ($keys as $key)
            {
                $expected = array_column($this->category->allCategories(), $key);

                $order == SORT_ASC ? sort($expected) : rsort($expected);

                $actual = array_column($this->category->sortBy($key, $order), $key);

                $this->assertSame($expected, $actual);
            }
        }
    }

    public function test_getLanguage_should_return_en_or_np()
    {
        $this->assertTrue(in_array($this->category->getLanguage(), ['en', 'np']));
    }
}
