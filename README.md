# Aatis Logger

## Installation

```bash
composer require aatis/logger
```

## Usage

### Requirements

By default the log file is set to `var/app.log` and the timezone is set to `Europe/Paris` but you can change them by setting the `LOG_PATH` and `TIMEZONE` environment variables.

### Basic method

Choose a `LogLevel` for the message you want to log and pass the message with it context.

Your can include variable into your message with the following syntax : `{variable}`

```php
    $var = 'set';

    $logger->log(LogLevel::INFO, 'Logger is {example} !', ['example' => $var]);

    // Output : [14-01-2024 22:06:12] INFO      Logger is set !
```

### Specific methods

You can use the following methods to log a message with a specific level of log.

Like the basic method, each ones take the message and the context of it as parameters.

```php
    $logger->info('Info message');              // Output : [14-01-2024 22:06:12] INFO      Info message
    $logger->notice('Notice message');          // Output : [14-01-2024 22:06:12] NOTICE    Notice message
    $logger->warning('Warning message');        // Output : [14-01-2024 22:06:12] WARNING   Warning message
    $logger->error('Error message');            // Output : [14-01-2024 22:06:12] ERROR     Error message
    $logger->critical('Critical message');      // Output : [14-01-2024 22:06:12] CRITICAL  Critical message
    $logger->alert('Alert message');            // Output : [14-01-2024 22:06:12] ALERT     Alert message
    $logger->emergency('Emergency message');    // Output : [14-01-2024 22:06:12] EMERGENCY Emergency message
    $logger->debug('Debug message');            // Output : [14-01-2024 22:06:12] DEBUG     Debug message
```

## With Aatis Framework

### Requirements

Add the `Logger` to the `Container`:

```yaml
# In config/services.yaml file :

include_services:
    - 'Aatis\Logger\Service\Logger'
```
