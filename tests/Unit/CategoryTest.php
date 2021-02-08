<?php


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
    private $language;

    /**
     * CategoryTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->language = $_ENV['APP_LANG'];
        $this->category = new Category($this->language);
    }

    /**
     * Test Category Find By ID
     */
    public function testFind()
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

    /**
     * Test Find Category By Short Code
     */
    public function testFindByShortCode()
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

    /**
     * Test Null Values in Category Data
     */
    public function testNullValues()
    {
        $hasNull = false;
        foreach ($this->category->allCategories() as $set) {
            if ($hasNull = in_array(null, (array) $set, true)) {
                $this->fail('Category dataset can\'t have null values');
                break;
            }
        }
        if(!$hasNull)
            $this->assertTrue(true);
    }

    /**
     * Test Number of All Categories
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testAllProvinces()
    {
        if(count($this->category->allCategories()) == 4){
            $this->assertTrue(true);
        }else{
            $this->fail('Only Four Categories of Local Level Exists in Nepal');
        }
    }

    /**
     * Test Category Search
     */
    public function testSearch()
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

    /**
     * Test Recursive Search
     */
    public function testRecursiveSearch()
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

    /**
     * Test sort by feature on categories
     */
    public function testSortBy()
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
}
