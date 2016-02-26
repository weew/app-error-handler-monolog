<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use PHPUnit_Framework_TestCase;
use Psr\Log\LogLevel;
use Weew\App\ErrorHandler\Monolog\ErrorCodeToLogLevelMap;

class ErrorCodeToLogLevelMapTest extends PHPUnit_Framework_TestCase {
    public function test_get_map() {
        $this->assertTrue(is_array(ErrorCodeToLogLevelMap::getMap()));
    }

    public function test_get_error() {
        $this->assertEquals(
            LogLevel::CRITICAL, ErrorCodeToLogLevelMap::getLogLevelForErrorCode(E_ERROR)
        );
    }
}
