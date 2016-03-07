<?php

namespace Weew\App\ErrorHandler\Monolog;

use Weew\Config\IConfig;

class MonologErrorHandlerConfig implements IMonologErrorHandlerConfig {
    const ERROR_CHANNEL_NAME = 'monolog_error_handler.channel_name';

    /**
     * @var IConfig
     */
    protected $config;

    /**
     * MonologErrorHandlerConfig constructor.
     *
     * @param IConfig $config
     */
    public function __construct(IConfig $config) {
        $this->config = $config;
        $config
            ->ensure(self::ERROR_CHANNEL_NAME, 'Missing name of the error channel.');
    }

    public function getErrorChannelName() {
        return $this->config->get(self::ERROR_CHANNEL_NAME);
    }
}
