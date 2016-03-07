<?php

namespace Weew\App\ErrorHandler\Monolog;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Weew\App\Monolog\IMonologChannelManager;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;

class MonologErrorHandlingProvider {
    /**
     * MonologErrorHandlingProvider constructor.
     *
     * @param IContainer $container
     */
    public function __construct(IContainer $container) {
        $container->set(IMonologErrorHandlerConfig::class, MonologErrorHandlerConfig::class);
    }

    /**
     * @param IContainer $container
     * @param IMonologErrorHandlerConfig $monologConfig
     * @param IErrorHandler $errorHandler
     * @param IMonologChannelManager $channelManager
     */
    public function initialize(
        IContainer $container,
        IMonologErrorHandlerConfig $monologConfig,
        IErrorHandler $errorHandler,
        IMonologChannelManager $channelManager
    ) {
        $logger = $channelManager->getLogger($monologConfig->getErrorChannelName());
        $monologErrorHandler = new MonologErrorHandler($logger, $errorHandler);
        $monologErrorHandler->enableErrorHandling();
        $monologErrorHandler->enableExceptionHandling();

        $container->set(
            [MonologErrorHandler::class], $monologErrorHandler
        );
    }
}
