<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use PHPUnit_Framework_TestCase;
use Psr\Log\LogLevel;
use Weew\App\ErrorHandler\Monolog\MonologConfig;
use Weew\Config\Config;
use Weew\Config\Exceptions\MissingConfigException;

class MonologConfigTest extends PHPUnit_Framework_TestCase {
    public function test_create_without_logs_path_throws_error() {
        $config = new Config();
        $this->setExpectedException(MissingConfigException::class);
        $monologConfig = new MonologConfig($config);
    }

    public function test_create_without_log_level_throws_error() {
        $config = new Config();
        $config->set(MonologConfig::LOG_FILE_PATH, __DIR__);
        $this->setExpectedException(MissingConfigException::class);
        $monologConfig = new MonologConfig($config);
    }

    public function test_get_log_file_path() {
        $config = new Config();
        $config->setConfig([
            MonologConfig::LOG_FILE_PATH => __DIR__,
            MonologConfig::LOG_LEVEL => LogLevel::INFO,
        ]);
        $monologConfig = new MonologConfig($config);
        $this->assertEquals(__DIR__, $monologConfig->getLogFilePath());
    }

    public function test_get_logger_name() {
        $config = new Config();
        $config->setConfig([
            MonologConfig::LOG_FILE_PATH => __DIR__,
            MonologConfig::LOG_LEVEL => LogLevel::INFO,
            MonologConfig::LOGGER_NAME => 'logger_name'
        ]);
        $monologConfig = new MonologConfig($config);
        $this->assertEquals('logger_name', $monologConfig->getLoggerName());
    }

    public function tet_get_logger_name_from_default_value() {
        $config = new Config();
        $config->setConfig([
            MonologConfig::LOG_FILE_PATH => __DIR__,
            MonologConfig::LOG_LEVEL => LogLevel::INFO,
        ]);
        $monologConfig = new MonologConfig($config);
        $this->assertEquals('default', $monologConfig->getLoggerName());
    }
    
    public function test_get_log_level() {
        $config = new Config();
        $config->setConfig([
            MonologConfig::LOG_FILE_PATH => __DIR__,
            MonologConfig::LOG_LEVEL => LogLevel::INFO,
        ]);
        $monologConfig = new MonologConfig($config);
        $this->assertEquals(LogLevel::INFO, $monologConfig->getLogLevel());
    }
}
