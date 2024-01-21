<?php
namespace Sagautam5\LocalStateNepal\Test;

use PHPUnit\Framework\TestCase;
use Sagautam5\LocalStateNepal\Entities\Category;

/**
 * Class LocalStateTest
 */
abstract class LocalStateTest extends TestCase
{
    /**
     * LocalStateTest constructor.
     */
    public function __construct($name = null, array $data = [], $dataName = '') 
    {
        parent::__construct($name, $data, $dataName);
    }
}
