<?php

namespace Aatis\Logger\Service;

use Aatis\FileManager\Interface\FileManagerInterface;
use Psr\Log\LoggerInterface;
use Aatis\Logger\Enum\LogLevel;
use Psr\Log\InvalidArgumentException;

class Logger implements LoggerInterface
{
    public function __construct(private readonly FileManagerInterface $fileManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->fileManager->read('path/to/file', false);
        // LogLevel::cases()[$level] ?? throw new InvalidArgumentException('Invalid log level');
        // not loglevel -> InvalidArgumentException

        // if Stringable -> ToString() -> invalidArgumentException

        // placeholder into message {context_key.Re78}

        // open file / interpolate / write in
        $this->interpolate($message, $context);
    }

    /**
     * @param mixed[] $context
     */
    private function interpolate(string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $value) {
            $replace['{'.$key.'}'] = $value;
        }

        return strtr($message, $replace);
    }
}
