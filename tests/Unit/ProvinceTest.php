<?php

use Sagautam5\LocalStateNepal\Entities\Province;

/**
 * Class ProvinceTest
 */
class ProvinceTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Province
     */
    private $province;

    /**
     * @var array
     */
    private $language;

    /**
     * ProvinceTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->language = $_ENV['APP_LANG'];

        $this->province = new Province($this->language);
    }

    /**
     * Test Largest Province
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testLargest()
    {
        $largest = $this->province->largest();
        $largest->id == 6 ? $this->assertTrue(true): $this->fail('Not a Largest Province');
    }

    /**
     * Test Find Province By ID
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testFind()
    {
        $correctIdSet = range(1,7);
        $incorrectIdSet = range(8,15);

        $correctStatus = true;
        foreach ($correctIdSet as $id)
        {
            $item = $this->province->find($id);

            if(!$item){
                $correctStatus= false;
            }
        }
        $this->assertTrue($correctStatus);


        $correctStatus = false;
        foreach ($incorrectIdSet as $id)
        {
            if($this->province->find($id)){
                $correctStatus= true;
            }
        }
        $this->assertFalse($correctStatus);
    }

    /**
     * Test Smallest Province
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testSmallest()
    {
        $smallest = $this->province->smallest();
        $smallest->id == 2 ? $this->assertTrue(true): $this->fail('Not a Smallest Province');
    }

    /**
     * Test Number of All Provinces
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testAllProvinces()
    {
        if(count($this->province->allProvinces()) == 7){
            $this->assertTrue(true);
        }else{
            $this->fail('Only Seven Provinces Exists in Nepal');
        }
    }

    /**
     * Test Null Values in Provinces Data
     */
    public function testNullValues()
    {
        $hasNull = false;
        foreach ($this->province->allProvinces() as $set) {
            if ($hasNull = in_array(null, (array) $set, true)) {
                $this->fail('Province dataset can\'t have null values');
                break;
            }
        }
        if(!$hasNull)
            $this->assertTrue(true);
    }

    /**
     * Test Province Search
     */
    public function testSearch()
    {
        $provinces = $this->province->allProvinces();
        $keywords = ['id', 'name', 'area_sq_km', 'website', 'headquarter'];

        $correct = true;
        foreach ($keywords as $key){
            $dataSet = array_column($provinces, $key);
            foreach ($dataSet as $item){
                if(!count($this->province->search($key, $item, true))){
                    $correct = false;
                    $this->fail('Province not found for '.$key.' => '.$item);
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
            ['key' => 'name', 'value' => 'mati', 'exact' => false],
            ['key' => 'headquarter', 'value' => 'Hetauda', 'exact' => false]
        ]:[
            ['key' => 'name', 'value' => 'मती', 'exact' => false],
            ['key' => 'headquarter', 'value' => 'हेटौडा', 'exact' => false]
        ];

        $result = $this->province->recursiveSearch($params);

        if(!$result){
            $this->fail('Not Found');
        }

        $this->assertTrue(true);
    }

    /**
     * Test sort by feature on province
     */
    public function testSortBy()
    {
        $keys = $this->province->getKeys();

        $orders = array(SORT_ASC, SORT_DESC);

        foreach ($orders as $order)
        {
            foreach ($keys as $key)
            {
                $expected = array_column($this->province->allProvinces(), $key);

                $order == SORT_ASC ? sort($expected) : rsort($expected);

                $actual = array_column($this->province->sortBy($key, $order), $key);

                $this->assertSame($expected, $actual);
            }
        }
    }
}
