<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use PHPUnit_Framework_TestCase;
use Weew\App\App;
use Weew\App\ErrorHandler\ErrorHandlingProvider;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandlerConfig;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandler;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandlingProvider;
use Weew\App\Monolog\MonologConfig;
use Weew\App\Monolog\MonologProvider;

class MonologErrorHandlingProviderTest extends PHPUnit_Framework_TestCase {
    private function createApp() {
        $app = new App();
        $config = $app->loadConfig();
        $config->set(MonologConfig::DEFAULT_CHANNEL_NAME, 'error');
        $config->set(s(MonologConfig::LOG_CHANNEL_FILE_PATH, 'error'), path(__DIR__, 'error.txt'));
        $config->set(s(MonologConfig::LOG_CHANNEL_LOG_LEVEL, 'error'), 'debug');
        $config->set(MonologErrorHandlerConfig::ERROR_CHANNEL_NAME, 'error');

        return $app;
    }

    public function test_error_handler_is_shared_in_the_container() {
        $app = $this->createApp();
        $app->getKernel()->addProviders([
            ErrorHandlingProvider::class,
            MonologProvider::class,
            MonologErrorHandlingProvider::class,
        ]);
        $app->start();

        $logger = $app->getContainer()->get(MonologErrorHandler::class);
        $this->assertTrue($logger instanceof MonologErrorHandler);
    }
}
