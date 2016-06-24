<?php

namespace Weew\App\ErrorHandler\Monolog;

use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Weew\ErrorHandler\Errors\IError;
use Weew\ErrorHandler\ErrorType;
use Weew\ErrorHandler\IErrorHandler;

class MonologErrorHandler {
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var IErrorHandler
     */
    private $errorHandler;

    /**
     * MonologErrorHandler constructor.
     *
     * @param LoggerInterface $logger
     * @param IErrorHandler $errorHandler
     */
    public function __construct(
        LoggerInterface $logger,
        IErrorHandler $errorHandler
    ) {
        $this->setLogger($logger);
        $this->setErrorHandler($errorHandler);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger() {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @return IErrorHandler
     */
    public function getErrorHandler() {
        return $this->errorHandler;
    }

    /**
     * @param IErrorHandler $errorHandler
     */
    public function setErrorHandler(IErrorHandler $errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    /**
     * Enable error logging.
     */
    public function enableErrorHandling() {
        $this->errorHandler->addRecoverableErrorHandler(
            [$this, 'handleRecoverableError']
        );
        $this->errorHandler->addFatalErrorHandler(
            [$this, 'handleFatalError']
        );
    }

    /**
     * Enable exception logging.
     */
    public function enableExceptionHandling() {
        $this->errorHandler->addExceptionHandler(
            [$this, 'handleException']
        );
    }

    /**
     * @param IError $error
     *
     * @return bool
     */
    public function handleRecoverableError(IError $error) {
        $logLevel = ErrorCodeToLogLevelMap::getLogLevelForErrorCode($error->getCode());
        $message = s(
            '%s: %s',
            ErrorType::getErrorTypeName($error->getCode()),
            $error->getMessage()
        );
        $details = [
            'code' => $error->getCode(),
            'message' => $error->getMessage(),
            'file' => $error->getFile(),
            'line' => $error->getLine(),
        ];

        $this->logger->log($logLevel, $message, $details);
    }

    /**
     * @param IError $error
     *
     * @return bool
     */
    public function handleFatalError(IError $error) {
        $logLevel = ErrorCodeToLogLevelMap::getLogLevelForErrorCode($error->getCode());
        $message = s(
            'Fatal Error (%s): %s',
            ErrorType::getErrorTypeName($error->getCode()),
            $error->getMessage()
        );
        $details = [
            'code' => $error->getCode(),
            'message' => $error->getMessage(),
            'file' => $error->getFile(),
            'line' => $error->getLine(),
        ];

        $this->logger->log($logLevel, $message, $details);
    }

    /**
     * @param Exception $ex
     *
     * @return bool
     */
    public function handleException(Exception $ex) {
        $message = s(
            'Uncaught Exception %s: "%s" at %s line %s',
            get_class($ex),
            $ex->getMessage(),
            $ex->getFile(),
            $ex->getLine()
        );

        $this->logger->log(LogLevel::ERROR, $message, ['exception' => $ex]);
    }
}
