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
    private $language;

    /**
     * ProvinceDistrictFeatureTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->language = $_ENV['APP_LANG'];
        $this->province = new Province($this->language);
    }

    /**
     * Test If Districts Are Correctly Loaded With Provinces
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function test_getProvincesWithDistricts()
    {
        $provinceWithDistricts = $this->province->getProvincesWithDistricts();

        $correct = true;
        foreach ($provinceWithDistricts as $item) {
            if (!(isset($item->districts) && is_array($item->districts))) {
                $correct = false;
                $this->fail('Failed to get associated districts of provinces');
            }
        }

        $this->assertTrue($correct);
    }

    /**
     * Check if Districts And Their Municipalities Are Correctly Loaded With  Provinces
     *
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function test_getProvincesWithDistrictsWithMunicipalities()
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

        $this->assertTrue($correct);
    }
}
