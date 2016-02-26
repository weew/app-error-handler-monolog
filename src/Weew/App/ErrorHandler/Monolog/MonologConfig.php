<?php

namespace Weew\App\ErrorHandler\Monolog;

use Weew\Config\IConfig;

class MonologConfig implements IMonologConfig {
    const LOG_FILE_PATH = 'monolog.log_file_path';
    const LOG_LEVEL = 'monolog.log_level';
    const LOGGER_NAME = 'monolog.logger_name';

    /**
     * @var IConfig
     */
    protected $config;

    /**
     * MonologConfig constructor.
     *
     * @param IConfig $config
     */
    public function __construct(IConfig $config) {
        $this->config = $config;

        $config
            ->ensure(self::LOG_FILE_PATH, 'Missing monolog logs directory path.');

        $logLevels = implode(', ', [
            'debug', 'info', 'notice', 'warning',
            'error', 'critical', 'alert', 'emergency'
        ]);
        $message = s('Missing log level, it must be one of this (%s) values.', $logLevels);
        $config->ensure(self::LOG_LEVEL, $message);
    }

    /**
     * @return string
     */
    public function getLogFilePath() {
        return $this->config->get(self::LOG_FILE_PATH);
    }

    /**
     * @return string
     */
    public function getLoggerName() {
        return $this->config->get(self::LOGGER_NAME, 'default');
    }

    /**
     * @return int
     */
    public function getLogLevel() {
        return $this->config->get(self::LOG_LEVEL);
    }
}
