<?php
namespace Sagautam5\LocalStateNepal\Test\Feature;

use PHPUnit_Framework_TestCase;
use Sagautam5\LocalStateNepal\Entities\Municipality;

/**
 * Class ProvinceDistrictFeatureTest
 */
class StatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $language;

    /**
     * @var Municipality
     */
    private $municipality;

    /**
     * ProvinceDistrictFeatureTest constructor.D
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        parent::__construct();
        $this->language = $_ENV['APP_LANG'];
        $this->municipality = new Municipality($this->language);
    }

    public function test_TotalWardsCount()
    {
        $allMunicipalities = $this->municipality->allMunicipalities();

        $totalWards = array_reduce($allMunicipalities, function($mWards, $municipality)
        {
            return $mWards + $municipality->wards;
        },0);

        $this->assertSame(6743, $totalWards);
    }

    public function test_TotalWardsByCategory()
    {
        $data = [
            'metropolitan' => 0,
            'subMetropolitan' => 0,
            'municipality' => 0,
            'ruralMunicipality' => 0
        ];
        $allMunicipalities = $this->municipality->allMunicipalities();

        foreach ($allMunicipalities as $municipality){
            switch ($municipality->category_id){
                case '1':
                    $data['metropolitan'] += $municipality->wards;
                    break;
                case '2':
                    $data['subMetropolitan'] += $municipality->wards;
                    break;
                case '3':
                    $data['municipality'] += $municipality->wards;
                    break;
                case '4':
                    $data['ruralMunicipality'] += $municipality->wards;
                    break;
                default:
                    break;
            }
        }

        $this->assertSame($data['metropolitan'],174);
        $this->assertSame($data['subMetropolitan'],234);
        $this->assertSame($data['municipality'],3120);
        $this->assertSame($data['ruralMunicipality'],3215);

        $this->assertSame(array_sum($data), 6743);
    }
}
