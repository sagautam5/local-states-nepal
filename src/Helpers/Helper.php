<?php


namespace Sagautam5\LocalStateNepal\Helpers;

/**
 * Class Helper
 * @package Sagautam5\LocalStateNepal\Helpers
 */
class Helper
{
    /**
     * @var array
     */
    private static $nepali = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];

    /**
     * @var array
     */
    private static $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * Convert English Numeric Value to Nepali Numeric Value
     *
     * @param $value
     * @return mixed
     */
    public static function numericNepali($value)
    {
        for ($i = 0; $i < 10; $i++)
        {
            $value = str_replace(self::$english[$i], self::$nepali[$i], $value);
        }

        return $value;
    }

    /**
     * Convert Nepali Numeric Value to English Numeric Value
     *
     * @param $value
     * @return mixed
     */
    public static function numericEnglish($value)
    {
        for ($i = 0; $i < 10; $i++)
        {
            $value = str_replace(self::$nepali[$i], self::$english[$i], $value);
        }
        return $value;
    }
}