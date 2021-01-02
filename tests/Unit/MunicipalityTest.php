<?php


use Sagautam5\LocalStateNepal\Entities\Municipality;

/**
 * Class MunicipalityTest
 */
class MunicipalityTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Municipality
     */
    private $municipality;

    /**
     * @var array
     */
    private $languages = ['en', 'np'];

    /**
     * MunicipalityTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->municipality = new Municipality($this->languages[array_rand($this->languages)]);
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

    /**
     * Test Municipality Wards
     */
    public function testMunicipalityWards()
    {
        $lang = $this->municipality->getLanguage();
        if($lang == 'np'){
            $wards = range(1,33);
            $wards = array_map(function ($item){
                return \Sagautam5\LocalStateNepal\Helpers\Helper::numericNepali($item);
            }, $wards);
        }else{
            $wards = range(1,33);
        }
        $idSet = range(1,753);

        $correct = true;
        foreach ($idSet as $id)
        {
            if(array_diff($this->municipality->wards($id), $wards))
            {
                $correct = false;
                break;
            }
        }

        if($correct)
            $this->assertTrue(true);
        else
            $this->fail('Invalid Wards for Municipality');
    }

    /**
     * Test Municipality Categories
     */
    public function testMunicipalityCategories()
    {
        $idSet = range(1,753);

        $correct = true;
        foreach ($idSet as $id)
        {
            $municipality = $this->municipality->find($id);
            if($municipality && !in_array($municipality->category_id, range(1,4))){
                $correct = false;
                break;
            }
        }

        if($correct)
            $this->assertTrue(true);
        else
            $this->fail('Invalid Category for Municipality');

    }

    /**
     * Test Municipality Categories
     */
    public function testMunicipalityDistrict()
    {
        $idSet = range(1,753);

        $correct = true;
        foreach ($idSet as $id)
        {
            $municipality = $this->municipality->find($id);
            if($municipality && !in_array($municipality->district_id, range(1,77))){
                $correct = false;
                break;
            }
        }

        if($correct)
            $this->assertTrue(true);
        else
            $this->fail('Invalid District for Municipality');

    }
}
