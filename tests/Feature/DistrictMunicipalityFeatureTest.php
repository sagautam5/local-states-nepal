<?php


use Sagautam5\LocalStateNepal\Entities\District;

class DistrictMunicipalityFeatureTest extends PHPUnit_Framework_TestCase
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
     * DistrictMunicipalityFeatureTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->district = new District($this->languages[array_rand($this->languages)]);
    }

    /**
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function testGetDistrictsWithMunicipalities()
    {
        $districtsWithMunicipalities = $this->district->getDistrictsWithMunicipalities();

        $correct = true;
        foreach ($districtsWithMunicipalities as $item) {
            if (!(isset($item->municipalities) && is_array($item->municipalities))) {
                $correct = false;
                $this->fail('Failed to get associated municipalities of district');
            }
        }

        if ($correct)
            $this->assertTrue(true);
    }
}
