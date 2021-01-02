<?php


use Sagautam5\LocalStateNepal\Entities\Municipality;

class MunicipalityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Municipality
     */
    private $municipality;

    /**
     * MunicipalityTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->municipality = new Municipality('en');
    }

    /**
     * Test Largest Province
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testLargest()
    {
        $largest = $this->municipality->largest();
        $largest->id == 617 && $largest->district_id==62 && $largest->category_id == 4 ? $this->assertTrue(true): $this->fail('Not a Largest Municipality');
    }

    /**
     * Test Find Municipality By ID
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testFind()
    {
        $correctIdSet = range(1,753);
        $incorrectIdSet = range(754,1000);

        $correctStatus = true;
        foreach ($correctIdSet as $id)
        {
            $item = $this->municipality->find($id);

            if(!$item){
                $correctStatus= false;
            }
        }
        $this->assertTrue($correctStatus);


        $correctStatus = false;
        foreach ($incorrectIdSet as $id)
        {
            if($this->municipality->find($id)){
                $correctStatus= true;
            }
        }
        $this->assertFalse($correctStatus);
    }

    /**
     * Test Smallest Municipality
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testSmallest()
    {
        $smallest = $this->municipality->smallest();
        ($smallest->id == 274 && $smallest->district_id == 23 && $smallest->category_id == 3) ? $this->assertTrue(true): $this->fail('Not a Smallest Municipality');
    }

    /**
     * Test Number of All Municipalities
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testAllProvinces()
    {
        if(count($this->municipality->allMunicipalities()) == 753){
            $this->assertTrue(true);
        }else{
            $this->fail('Only 753 Local States Exists in Nepal');
        }
    }

    /**
     * Test Null Values in Municipality Data
     */
    public function testNullValues()
    {
        $hasNull = false;
        foreach ($this->municipality->allMunicipalities() as $set) {
            if ($hasNull = in_array(null, (array) $set, true)) {
                break;
            }
        }
        if($hasNull)
            $this->fail('Municipality dataset can\'t have null values');
        else
            $this->assertTrue(true);
    }
}
