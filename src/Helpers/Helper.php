<?php


namespace Sagautam5\LocalStateNepal\Helpers;

/**
 * Class Helper
 * @package Sagautam5\LocalStateNepal\Helpers
 */
class Helper
{
    /**
     * @var array<string>
     */
    private static $nepali = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];

    /**
     * @var array<string>
     */
    private static $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * Convert english numeric value to nepali numeric value
     *
     * @param string $value
     * @return string
     */
    public static function numericNepali($value): string
    {
        for ($i = 0; $i < 10; $i++)
        {
            $value = str_replace(self::$english[$i], self::$nepali[$i], $value);
        }

        return $value;
    }

    /**
     * Convert nepali numeric value to english numeric value
     *
     * @param string $value
     * @return string
     */
    public static function numericEnglish($value): string
    {
        for ($i = 0; $i < 10; $i++)
        {
            $value = str_replace(self::$nepali[$i], self::$english[$i], $value);
        }
        return $value;
    }
}