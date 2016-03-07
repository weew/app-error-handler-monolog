<?php

namespace Weew\App\ErrorHandler\Monolog;

interface IMonologErrorHandlerConfig {
    /**
     * @return string
     */
    function getErrorChannelName();
}
