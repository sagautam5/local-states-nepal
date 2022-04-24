<?php
namespace Sagautam5\LocalStateNepal\Test\Unit;

use PHPUnit_Framework_TestCase;
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
        parent::__construct();

        $this->language = $_ENV['APP_LANG'];
        $this->district = new District($this->language);
    }

    public function test_largest_district()
    {
        $largest = $this->district->largest();
        $this->assertSame([61,6],[$largest->id, $largest->province_id]);
    }

    public function test_find_for_range_between_1_to_77()
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

    public function test_smallest_district()
    {
        $smallest = $this->district->smallest();
        $this->assertSame([23,3], [$smallest->id, $smallest->province_id]);
    }

    public function test_allDistricts_for_count()
    {
        if(count($this->district->allDistricts()) == 77){
            $this->assertTrue(true);
        }else{
            $this->fail('Only 77 Districts Exists in Nepal');
        }
    }

    public function test_allDistricts_for_null_values()
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

    public function test_district_for_correct_province_id()
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

    public function test_getLanguage_should_return_en_or_np()
    {
        $this->assertTrue(in_array($this->district->getLanguage(), ['en', 'np']));
    }
}
