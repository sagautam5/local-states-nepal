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
    private $languages = ['en', 'np'];

    /**
     * CategoryTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->category = new Category($this->languages[array_rand($this->languages)]);
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
        $dataSet = array_column($categories, 'name');

        $correct = true;
        foreach ($dataSet as $item){
            if(!count($this->category->search($item))){
                $correct = false;
                $this->fail('Municipality Category '. $item. ' not found');
            }
        }

        $this->assertTrue($correct);
    }
}
