<?php

use Sagautam5\LocalStateNepal\Entities\Province;

class ProvinceTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test Largest Province
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testLargest()
    {
        $province = new Province('en');
        $largest = $province->largest();
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
            $province = new Province('en');
            $item = $province->find($id);

            if(!$item){
                $correctStatus= false;
            }
        }
        $this->assertTrue($correctStatus);


        $correctStatus = false;
        foreach ($incorrectIdSet as $id)
        {
            $province = new Province('en');
            if($province->find($id)){
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
        $province = new Province('en');
        $smallest = $province->smallest();
        $smallest->id == 2 ? $this->assertTrue(true): $this->fail('Not a Smallest Province');
    }

    /**
     * Test Number of All Provinces
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testAllProvinces()
    {
        $province = new Province('en');
        if(count($province->allProvinces()) == 7){
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
        $this->assertTrue(true);
    }
}
