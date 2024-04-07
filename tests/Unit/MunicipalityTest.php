<?php
namespace Sagautam5\LocalStateNepal\Test\Unit;

use PHPUnit\Framework\TestCase;
use Sagautam5\LocalStateNepal\Entities\Municipality;

/**
 * Class MunicipalityTest
 */
class MunicipalityTest extends TestCase
{
    /**
     * @var Municipality
     */
    private $municipality;

    /**
     * @var array
     */
    private $language;

    /**
     * MunicipalityTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        parent::__construct();

        $this->language = $_ENV['APP_LANG'];

        $this->municipality = new Municipality($this->language);
    }

    public function test_largest_municipality()
    {
        $largest = $this->municipality->largest();

        $this->assertSame([617,62,4],[$largest->id, $largest->district_id, $largest->category_id]);
    }

    public function test_find_for_range_between_1_and_753()
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

    public function test_smallest_municipality()
    {
        $smallest = $this->municipality->smallest();
        $this->assertSame([274,23,3],[$smallest->id, $smallest->district_id, $smallest->category_id]);
    }

    public function test_allMunicipalities_count()
    {
        if(count($this->municipality->allMunicipalities()) == 753){
            $this->assertTrue(true);
        }else{
            $this->fail('Only 753 Local States Exists in Nepal');
        }
    }

    public function test_allMunicipalities_for_null_values()
    {
        foreach ($this->municipality->allMunicipalities() as $set) {
            if (in_array(null, (array) $set, true)) {
                $this->fail('Municipality dataset can\'t have null values');
            }
        }

        $this->assertTrue(true);
    }

    public function test_if_municipality_has_wards_in_range_of_5_to_33()
    {
        $lang = $this->municipality->getLanguage();
        if($lang == 'np'){
            $wards = range(1,33);
            $wards = array_map(function ($item){
                return \Sagautam5\LocalStateNepal\Helpers\Helper::numericNepali((string) $item);
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
                $this->fail('Invalid Wards for Municipality');
            }
        }

        $this->assertTrue($correct);
    }

    public function test_if_municipality_has_correct_category_id()
    {
        $idSet = range(1,753);

        $correct = true;
        foreach ($idSet as $id)
        {
            $municipality = $this->municipality->find($id);
            if($municipality && !in_array($municipality->category_id, range(1,4))){
                $correct = false;
                $this->fail('Invalid Category for Municipality');
            }
        }

        $this->assertTrue($correct);
    }

    public function test_if_municipality_has_correct_district_id()
    {
        $idSet = range(1,753);

        $correct = true;
        foreach ($idSet as $id)
        {
            $municipality = $this->municipality->find($id);
            if($municipality && !in_array($municipality->district_id, range(1,77))){
                $correct = false;
                $this->fail('Invalid District for Municipality');
            }
        }

        $this->assertTrue($correct);
    }


    public function test_search()
    {
        $municipalities = $this->municipality->allMunicipalities();
        $keywords = ['id', 'district_id', 'category_id', 'name', 'area_sq_km', 'website', 'wards'];

        $correct = true;
        foreach ($keywords as $key){
            $dataSet = array_column($municipalities, $key);
            foreach ($dataSet as $item){
                if(!count($this->municipality->search($key, $item, true))){
                    $correct = false;
                    $this->fail('Municipality not found for '.$key.' => '.$item);
                }
            }

        }

        $this->assertTrue($correct);
    }

    public function test_recursiveSearch()
    {
        $params = $_ENV['APP_LANG'] == 'en' ? [
            ['key' => 'name', 'value' => 'Jorpati', 'exact' => false],
        ]:[
            ['key' => 'name', 'value' => 'जोरपाटी', 'exact' => false],
        ];

        $result = $this->municipality->recursiveSearch($params);

        if(!$result){
            $this->fail('Not Found');
        }

        $this->assertTrue(true);
    }

    public function test_sortBy()
    {
        $keys = $this->municipality->getKeys();

        $orders = array(SORT_ASC, SORT_DESC);

        foreach ($orders as $order)
        {
            foreach ($keys as $key)
            {
                $expected = array_column($this->municipality->allMunicipalities(), $key);

                $order == SORT_ASC ? sort($expected) : rsort($expected);

                $actual = array_column($this->municipality->sortBy($key, $order), $key);

                $this->assertSame($expected, $actual);
            }
        }
    }

    public function test_getMunicipalityByProvince_for_individual_correct_count()
    {
        $expectedSet = array(
            '1' => 137,
            '2' => 136,
            '3' => 119,
            '4' => 85,
            '5' => 109,
            '6' => 79,
            '7' => 88
        );

        $actualSet = array();

        for ($index = 1; $index<=7; $index++){
            $actualSet[(string)$index] = count($this->municipality->getMunicipalityByProvince($index));
        }

        $this->assertSame($expectedSet, $actualSet);
    }

    public function test_getMunicipalityByProvince_for_total_count()
    {
        $expectedTotal = 753;

        $actualTotal = 0;
        for ($index = 1; $index<=7; $index++)
        {
            $actualTotal += count($this->municipality->getMunicipalityByProvince($index));
        }

        $this->assertSame($actualTotal, $expectedTotal);
    }

    public function test_getLanguage_should_return_en_or_np()
    {
        $this->assertTrue(in_array($this->municipality->getLanguage(), ['en', 'np']));
    }
}
