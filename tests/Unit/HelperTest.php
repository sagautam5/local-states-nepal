<?php
namespace Sagautam5\LocalStateNepal\Test\Unit;

use PHPUnit_Framework_TestCase;
use Sagautam5\LocalStateNepal\Helpers\Helper;

/**
 * Class HelperTest
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * English sample test set
     */
    private $englishSet = ['09','18', '27', '36', '45', '54', '63', '72', '81', '90'];

    /**
     * Nepali sample test set
     */
    private $nepaliSet  = ['०९', '१८', '२७', '३६', '४५', '५४', '६३', '७२', '८१', '९०'];

    /**
     * HelperTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->helper = new Helper();
    }

    public function test_nepali_to_english_conversion()
    {
        $correct = true;

        foreach($this->nepaliSet as $key => $number)
        {
            if($this->englishSet[$key] != $this->helper->numericEnglish($number)){
                $correct = false;
                break;
            }
        }
        
        $this->assertTrue($correct);
    }

    public function test_english_to_nepali_conversion()
    {
        $correct = true;

        foreach($this->englishSet as $key => $number)
        {
            if($this->nepaliSet[$key] != $this->helper->numericNepali($number)){
                $correct = false;
                break;
            }
        }
        
        $this->assertTrue($correct);
    }
}
