<?php

namespace Tests\Weew\App\ErrorHandler\Monolog;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit_Framework_TestCase;
use Psr\Log\LogLevel;
use Weew\App\ErrorHandler\Monolog\MonologErrorHandler;
use Weew\ErrorHandler\ErrorHandler;
use Weew\ErrorHandler\Errors\FatalError;
use Weew\ErrorHandler\Errors\RecoverableError;
use Weew\ErrorHandler\ErrorType;

class MonologErrorHandlerTest extends PHPUnit_Framework_TestCase {
    private function getLogPath() {
        return path(__DIR__, 'test.log');
    }

    private function clearLog() {
        file_write($this->getLogPath(), '');
    }

    private function getLogContent() {
        return file_read($this->getLogPath());
    }

    private function logHas($string) {
        return stripos($this->getLogContent(), $string) !== false;
    }

    private function createLogger() {
        $stream = new StreamHandler(
            $this->getLogPath(), LogLevel::DEBUG
        );
        $logger = new Logger('default');
        $logger->pushHandler($stream);

        return $logger;
    }

    public function test_get_and_set_logger() {
        $logger = $this->createLogger();
        $errorHandler = new ErrorHandler();
        $monologErrorHandler = new MonologErrorHandler(
            $logger, $errorHandler
        );
        $this->assertTrue($logger === $monologErrorHandler->getLogger());
    }

    public function test_get_and_set_error_handler() {
        $logger = $this->createLogger();
        $errorHandler = new ErrorHandler();
        $monologErrorHandler = new MonologErrorHandler(
            $logger, $errorHandler
        );
        $this->assertTrue($errorHandler === $monologErrorHandler->getErrorHandler());
    }

    public function test_enable_error_handling() {
        $errorHandler = new ErrorHandler();
        $monologErrorHandler = new MonologErrorHandler(
            $this->createLogger(), $errorHandler
        );
        $this->assertEquals(0, count($errorHandler->getRecoverableErrorHandlers()));
        $this->assertEquals(0, count($errorHandler->getFatalErrorHandlers()));
        $monologErrorHandler->enableErrorHandling();
        $this->assertEquals(1, count($errorHandler->getRecoverableErrorHandlers()));
        $this->assertEquals(1, count($errorHandler->getFatalErrorHandlers()));
    }

    public function test_enable_exception_handling() {
        $errorHandler = new ErrorHandler();
        $monologErrorHandler = new MonologErrorHandler(
            $this->createLogger(), $errorHandler
        );
        $this->assertEquals(0, count($errorHandler->getExceptionHandlers()));
        $monologErrorHandler->enableExceptionHandling();
        $this->assertEquals(1, count($errorHandler->getExceptionHandlers()));
    }

    public function test_handle_recoverable_error() {
        $this->clearLog();
        $monologErrorHandler = new MonologErrorHandler(
            $this->createLogger(), new ErrorHandler()
        );
        $monologErrorHandler->handleRecoverableError(
            new RecoverableError(ErrorType::COMPILE_ERROR, 'fake error', __FILE__, __LINE__)
        );
        $this->assertTrue($this->logHas('E_COMPILE_ERROR: fake error'));
    }

    public function test_handle_fatal_error() {
        $this->clearLog();
        $monologErrorHandler = new MonologErrorHandler(
            $this->createLogger(), new ErrorHandler()
        );
        $monologErrorHandler->handleFatalError(
            new FatalError(ErrorType::CORE_ERROR, 'fake error', __FILE__, __LINE__)
        );
        $this->assertTrue($this->logHas('Fatal Error (E_CORE_ERROR): fake error'));
    }

    public function test_handle_exception() {
        $this->clearLog();
        $monologErrorHandler = new MonologErrorHandler(
            $this->createLogger(), new ErrorHandler()
        );
        $monologErrorHandler->handleException(new Exception('fake error'));
        $this->assertTrue($this->logHas('Uncaught Exception Exception: "fake error"'));
    }
}
