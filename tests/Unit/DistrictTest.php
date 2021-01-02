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
    private $languages = ['en', 'np'];

    /**
     * DistrictTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->district = new District($this->languages[array_rand($this->languages)]);
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
                break;
            }
        }
        if($hasNull)
            $this->fail('District dataset can\'t have null values');
        else
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
                break;
            }
        }

        if($correct)
            $this->assertTrue(true);
        else
            $this->fail('Invalid Province for District');

    }
}
