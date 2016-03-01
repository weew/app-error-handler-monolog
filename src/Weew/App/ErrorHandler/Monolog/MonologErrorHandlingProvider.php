<?php

namespace Weew\App\ErrorHandler\Monolog;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;

class MonologErrorHandlingProvider {
    /**
     * MonologErrorHandlingProvider constructor.
     *
     * @param IContainer $container
     * @param MonologConfig $monologConfig
     * @param IErrorHandler $errorHandler
     */
    public function __construct(
        IContainer $container,
        MonologConfig $monologConfig,
        IErrorHandler $errorHandler
    ) {
        $logger = $this->createLogger($monologConfig);
        $monologErrorHandler = new MonologErrorHandler($logger, $errorHandler);
        $monologErrorHandler->enableErrorHandling();
        $monologErrorHandler->enableExceptionHandling();

        $container->set(
            [MonologErrorHandler::class], $monologErrorHandler
        );
    }

    /**
     * @param MonologConfig $monologConfig
     *
     * @return Logger
     */
    protected function createLogger(MonologConfig $monologConfig) {
        $stream = new StreamHandler(
            $monologConfig->getLogFilePath(), $monologConfig->getLogLevel()
        );
        $logger = new Logger($monologConfig->getLoggerName());
        $logger->pushHandler($stream);

        return $logger;
    }
}
