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
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testLargest()
    {
        $largest = $this->district->largest();
        ($largest->id == 61 && $largest->province_id == 6) ? $this->assertTrue(true): $this->fail('Not a Largest District');
    }

    /**
     * Test Find District By ID
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testFind()
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
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testSmallest()
    {
        $smallest = $this->district->smallest();
        ($smallest->id == 23 && $smallest->province_id == 3) ? $this->assertTrue(true): $this->fail('Not a Smallest District');
    }

    /**
     * Test Number of All Districts
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testAllDistricts()
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
    public function testNullValues()
    {
        $hasNull = false;
        foreach ($this->district->allDistricts() as $set) {
            if ($hasNull = in_array(null, (array) $set, true)) {
                $this->fail('District dataset can\'t have null values');
                break;
            }
        }
        if(!$hasNull)
            $this->assertTrue(true);
    }

    /**
     * Test Province of District
     */
    public function testDistrictProvince()
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

        if($correct)
            $this->assertTrue(true);

    }

    /**
     * Test District Search
     */
    public function testSearch()
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
}
