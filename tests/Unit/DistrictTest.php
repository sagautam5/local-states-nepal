<?php


use Sagautam5\LocalStateNepal\Entities\District;

/**
 * Class DistrictTest
 */
class DistrictTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var District
     */
    private $district;

    /**
     * @var array
     */
    private $language;

    /**
     * DistrictTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->language = $_ENV['APP_LANG'];
        $this->district = new District($this->language);
    }

    /**
     * Test Largest District
     */
    public function test_largest_District()
    {
        $largest = $this->district->largest();
        $this->assertSame([61,6],[$largest->id, $largest->province_id]);
    }

    /**
     * Test Find District By ID
     */
    public function test_find_For_Range_Between_1_to_77()
    {
        $correctIdSet = range(1,77);
        $incorrectIdSet = range(78,154);

        $correctStatus = true;
        foreach ($correctIdSet as $id)
        {
            $item = $this->district->find($id);

            if(!$item){
                $correctStatus= false;
            }
        }
        $this->assertTrue($correctStatus);


        $correctStatus = false;
        foreach ($incorrectIdSet as $id)
        {
            if($this->district->find($id)){
                $correctStatus= true;
            }
        }
        $this->assertFalse($correctStatus);
    }

    /**
     * Test Smallest District
     */
    public function test_smallest_district()
    {
        $smallest = $this->district->smallest();
        $this->assertSame([23,3], [$smallest->id, $smallest->province_id]);
    }

    /**
     * Test Number of All Districts
     */
    public function test_allDistricts_For_Count()
    {
        if(count($this->district->allDistricts()) == 77){
            $this->assertTrue(true);
        }else{
            $this->fail('Only 77 Districts Exists in Nepal');
        }
    }

    /**
     * Test Null Values in District Data
     */
    public function test_Null_Values()
    {
        $hasNull = false;
        foreach ($this->district->allDistricts() as $set) {
            if ($hasNull = in_array(null, (array) $set, true)) {
                $this->fail('District dataset can\'t have null values');
                break;
            }
        }

        $this->assertTrue(!$hasNull);
    }

    /**
     * Test Province of District
     */
    public function test_District_For_Correct_Province_ID()
    {
        $idSet = range(1,77);

        $correct = true;
        foreach ($idSet as $id)
        {
            $district = $this->district->find($id);
            if($district && !in_array($district->province_id, range(1,7))){
                $correct = false;
                $this->fail('Invalid Province for District');
                break;
            }
        }

        $this->assertTrue($correct);

    }

    /**
     * Test District Search
     */
    public function test_search()
    {
        $districts = $this->district->allDistricts();
        $keywords =  ['id', 'province_id', 'name', 'area_sq_km', 'website', 'headquarter'];

        $correct = true;
        foreach ($keywords as $key){
            $dataSet = array_column($districts, $key);
            foreach ($dataSet as $item){
                if(!count($this->district->search($key, $item, true))){
                    $correct = false;
                    $this->fail('District not found for '.$key.' => '. $item);
                }
            }
        }

        $this->assertTrue($correct);
    }

    /**
     * Test Recursive Search
     */
    public function test_recursiveSearch()
    {
        $params = $_ENV['APP_LANG'] == 'en' ? [
            ['key' => 'name', 'value' => 'Gulmi', 'exact' => false],
            ['key' => 'headquarter', 'value' => 'Tamghas', 'exact' => false],
            ['key' => 'province_id', 'value' => '5', 'exact' => false]
        ]:[
            ['key' => 'name', 'value' => 'गुल्', 'exact' => false],
            ['key' => 'headquarter', 'value' => 'तम्घा', 'exact' => false],
            ['key' => 'province_id', 'value' => '5', 'exact' => false]
        ];

        $result = $this->district->recursiveSearch($params);

        if(!$result){
            $this->fail('Not Found');
        }

        $this->assertTrue(true);
    }

    /**
     * Test sort by feature on districts
     */
    public function test_sortBy()
    {
        $keys = $this->district->getKeys();

        $orders = array(SORT_ASC, SORT_DESC);

        foreach ($orders as $order)
        {
            foreach ($keys as $key)
            {
                $expected = array_column($this->district->allDistricts(), $key);

                $order == SORT_ASC ? sort($expected) : rsort($expected);

                $actual = array_column($this->district->sortBy($key, $order), $key);

                $this->assertSame($expected, $actual);
            }
        }
    }
}
