<?php


use Sagautam5\LocalStateNepal\Entities\Municipality;

class MunicipalityCountByCategoryTest extends PHPUnit_Framework_TestCase
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
     * MunicipalityCountByCategoryTest constructor.
     * @throws \Sagautam5\LocalStateNepal\Exceptions\LoadingException
     */
    public function __construct()
    {
        $this->language = $_ENV['APP_LANG'];
        $this->municipality = new Municipality($this->language);
    }

    /**
     * Test Municipalities Count for Each Category
     */
    public function test_municipalityCountByCategory()
    {
        $categoryIdSet = range(1,4);
        $categoryCountSet = [6,11,276,460];

        $correct = true;
        foreach ($categoryIdSet as $key => $id)
        {
            $municipalities = $this->municipality->getMunicipalityByCategory($id);
            if (!(is_array($municipalities) && count($municipalities) == $categoryCountSet[$key])) {
                $correct = false;
                $this->fail('Failed to get associated municipalities of district');
            }
        }

        $this->assertTrue($correct);
    }
}
