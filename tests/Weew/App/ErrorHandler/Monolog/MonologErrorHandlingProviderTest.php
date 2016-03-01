<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use PHPUnit_Framework_TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Weew\App\App;
use Weew\App\ErrorHandler\ErrorHandlingProvider;
use Weew\App\ErrorHandler\Monolog\MonologConfig;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandler;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandlingProvider;

class MonologErrorHandlingProviderTest extends PHPUnit_Framework_TestCase {
    private function createApp() {
        $app = new App();
        $app->loadConfig()->merge([
            MonologConfig::LOG_FILE_PATH => __DIR__,
            MonologConfig::LOG_LEVEL => LogLevel::INFO,
        ]);

        return $app;
    }

    public function test_error_handler_is_shared_in_the_container() {
        $app = $this->createApp();
        $app->getKernel()->addProviders([
            ErrorHandlingProvider::class,
            MonologErrorHandlingProvider::class,
        ]);
        $app->start();

        $logger = $app->getContainer()->get(MonologErrorHandler::class);
        $this->assertTrue($logger instanceof MonologErrorHandler);
    }
}
