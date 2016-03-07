<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use PHPUnit_Framework_TestCase;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandlerConfig;
use Weew\Config\Config;
use Weew\Config\Exceptions\MissingConfigException;

class MonologErrorHandlerConfigTest extends PHPUnit_Framework_TestCase {
    public function test_get_logger_name_from_default_value() {
        $config = new Config();
        $this->setExpectedException(MissingConfigException::class);
        $monologConfig = new MonologErrorHandlerConfig($config);
    }
    
    public function test_get_error_channel_name() {
        $config = new Config();
        $config->set(MonologErrorHandlerConfig::ERROR_CHANNEL_NAME , 'error_channel');
        $monologConfig = new MonologErrorHandlerConfig($config);

        $this->assertEquals('error_channel', $monologConfig->getErrorChannelName());
    }
}
