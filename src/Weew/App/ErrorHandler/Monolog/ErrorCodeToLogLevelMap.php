<?php

namespace Weew\App\ErrorHandler\Monolog;

use Psr\Log\LogLevel;

class ErrorCodeToLogLevelMap {
    /**
     * @var array
     */
    protected static $errorTypeToLogLevelMap = [
        E_ERROR             => LogLevel::CRITICAL,
        E_WARNING           => LogLevel::WARNING,
        E_PARSE             => LogLevel::ALERT,
        E_NOTICE            => LogLevel::NOTICE,
        E_CORE_ERROR        => LogLevel::CRITICAL,
        E_CORE_WARNING      => LogLevel::WARNING,
        E_COMPILE_ERROR     => LogLevel::ALERT,
        E_COMPILE_WARNING   => LogLevel::WARNING,
        E_USER_ERROR        => LogLevel::ERROR,
        E_USER_WARNING      => LogLevel::WARNING,
        E_USER_NOTICE       => LogLevel::NOTICE,
        E_STRICT            => LogLevel::NOTICE,
        E_RECOVERABLE_ERROR => LogLevel::ERROR,
        E_DEPRECATED        => LogLevel::NOTICE,
        E_USER_DEPRECATED   => LogLevel::NOTICE,
    ];

    /**
     * @return array
     */
    public static function getMap() {
        return self::$errorTypeToLogLevelMap;
    }

    /**
     * @param $errorCode
     *
     * @return string
     */
    public static function getLogLevelForErrorCode($errorCode) {
        return array_get(self::$errorTypeToLogLevelMap, $errorCode);
    }
}
