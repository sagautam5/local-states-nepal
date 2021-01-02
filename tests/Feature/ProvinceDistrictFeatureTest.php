<?php


use Sagautam5\LocalStateNepal\Entities\Province;

/**
 * Class ProvinceDistrictFeatureTest
 */
class ProvinceDistrictFeatureTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Province
     */
    private $province;

    /**
     * @var array
     */
    private $languages = ['en', 'np'];

    /**
     * ProvinceDistrictFeatureTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->province = new Province($this->languages[array_rand($this->languages)]);
    }

    /**
     * Test If Districts Are Correctly Loaded With Provinces
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testGetProvincesWithDistricts()
    {
        $provinceWithDistricts = $this->province->getProvincesWithDistricts();

        $correct = true;
        foreach ($provinceWithDistricts as $item) {
            if (!(isset($item->districts) && is_array($item->districts))) {
                $correct = false;
                $this->fail('Failed to get associated districts of provinces');
            }
        }

        if ($correct)
            $this->assertTrue(true);
    }

    /**
     * Check if Districts And Their Municipalities Are Correctly Loaded With  Provinces
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testGetProvincesWithDistrictsWithMunicipalities()
    {
        $provinceWithDistrictWithMunicipalities = $this->province->getProvincesWithDistrictsWithMunicipalities();

        $correct = true;
        foreach ($provinceWithDistrictWithMunicipalities as $province) {
            if ((isset($province->districts) && is_array($province->districts))) {
                foreach ($province->districts as $district) {
                    if (!(isset($district->municipalities) && is_array($district->municipalities))) {
                        $correct = false;
                        $this->fail('Failed to get associated municipalities of districts');
                    }
                }
            } else {
                $correct = false;
                $this->fail('Failed to get associated municipalities of districts');
            }
        }

        if($correct)
            $this->assertTrue(true);
    }
}
