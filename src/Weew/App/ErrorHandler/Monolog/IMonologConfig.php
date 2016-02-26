<?php

namespace Weew\App\ErrorHandler\Monolog;

interface IMonologConfig {
    /**
     * @return string
     */
    function getLogFilePath();

    /**
     * @return string
     */
    function getLoggerName();

    /**
     * @return int
     */
    function getLogLevel();
}
