<?php
namespace Sagautam5\LocalStateNepal\Test\Feature;

use PHPUnit\Framework\TestCase;
use Sagautam5\LocalStateNepal\Entities\District;

class DistrictMunicipalityFeatureTest extends TestCase
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
     * DistrictMunicipalityFeatureTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        parent::__construct();

        $this->language = $_ENV['APP_LANG'];
        $this->district = new District($this->language);
    }

    /**
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function test_getDistrictsWithMunicipalities()
    {
        $districtsWithMunicipalities = $this->district->getDistrictsWithMunicipalities();

        $correct = true;
        foreach ($districtsWithMunicipalities as $item) {
            if (!(isset($item->municipalities) && is_array($item->municipalities))) {
                $correct = false;
                $this->fail('Failed to get associated municipalities of district');
            }
        }
        
        $this->assertTrue($correct);
    }
}
