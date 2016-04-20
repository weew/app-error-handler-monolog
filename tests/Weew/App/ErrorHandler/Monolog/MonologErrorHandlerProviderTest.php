<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use PHPUnit_Framework_TestCase;
use Weew\App\App;
use Weew\App\ErrorHandler\ErrorHandlerProvider;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandlerConfig;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandler;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandlerProvider;
use Weew\App\Monolog\MonologConfig;
use Weew\App\Monolog\MonologProvider;
use Weew\Config\Config;

class MonologErrorHandlerProviderTest extends PHPUnit_Framework_TestCase {
    private function createApp() {
        $app = new App();
        $config = new Config();
        $config->set(MonologConfig::DEFAULT_CHANNEL_NAME, 'error');
        $config->set(MonologConfig::LOG_CHANNEL_FILE_PATH('error'), path(__DIR__, 'error.txt'));
        $config->set(MonologConfig::LOG_CHANNEL_LOG_LEVEL('error'), 'debug');
        $config->set(MonologErrorHandlerConfig::ERROR_CHANNEL_NAME, 'error');

        $app->getConfigLoader()->addConfig($config);

        return $app;
    }

    public function test_error_handler_is_shared_in_the_container() {
        $app = $this->createApp();
        $app->getKernel()->addProviders([
            ErrorHandlerProvider::class,
            MonologProvider::class,
            MonologErrorHandlerProvider::class,
        ]);
        $app->start();
        $logger = $app->getContainer()->get(MonologErrorHandler::class);
        $this->assertTrue($logger instanceof MonologErrorHandler);
    }
}
