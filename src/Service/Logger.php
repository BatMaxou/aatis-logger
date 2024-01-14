<?php

namespace Aatis\Logger\Service;

use Aatis\FileManager\Interface\FileManagerInterface;
use Psr\Log\LoggerInterface;
use Aatis\Logger\Enum\LogLevel;
use Psr\Log\InvalidArgumentException;

class Logger implements LoggerInterface
{
    public function __construct(
        private readonly FileManagerInterface $fileManager,
        private readonly string $_log_path = '../var/log/app.log',
        private readonly string $_timezone = 'Europe/Paris'
    ) {
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

    /**
     * {@inheritdoc}
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!in_array($level, LogLevel::cases())) {
            throw new InvalidArgumentException('Invalid log level');
        }

        if ($message instanceof \Stringable) {
            $message = $message->__toString();
        }

        if (!is_string($message)) {
            throw new InvalidArgumentException('Message must be a string');
        }

        $content = $this->fileManager->read($this->_log_path);
        $message = $this->interpolate($message, $context);

        $this->fileManager->write(
            $this->_log_path,
            $content.$this->createLine($level, $message)
        );
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

    private function createLine(LogLevel $level, string $message): string
    {
        $tabs = strlen($level->name) < 6 ? "\t\t" : "\t";

        return '['
            .date_format(
                new \DateTime(timezone: new \DateTimeZone($this->_timezone)),
                'd-m-Y H:i:s'
            )
            .'] '
            .$level->name
            .$tabs
            .$message
            ."\n";
    }
}
