# Monolog error handler

[![Build Status](https://img.shields.io/travis/weew/php-app-error-handler-monolog.svg)](https://travis-ci.org/weew/php-app-error-handler-monolog)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-app-error-handler-monolog.svg)](https://scrutinizer-ci.com/g/weew/php-app-error-handler-monolog)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-app-error-handler-monolog.svg)](https://coveralls.io/github/weew/php-app-error-handler-monolog)
[![Version](https://img.shields.io/packagist/v/weew/php-app-error-handler-monolog.svg)](https://packagist.org/packages/weew/php-app-error-handler-monolog)
[![Licence](https://img.shields.io/packagist/l/weew/php-app-error-handler-monolog.svg)](https://packagist.org/packages/weew/php-app-error-handler-monolog)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)
- [Example config](#example-config)

## Installation

`composer require weew/php-app-error-handler-monolog`

## Introduction

This package integrates [Monolog](https://github.com/Seldaek/monolog) into the [weew/php-app-error-handler](https://github.com/weew/php-app-error-handler) package.

## Usage

To enable this provider simply register it on the kernel.

```php
$app->getKernel()->addProviders([
    ErrorHandlingProvider::class,
    MonologProvider::class,
    MonologErrorHandlingProvider::class,
]);
```

## Example config

This is how the config might look like in yaml:

```yaml
monolog_error_handler:
  channel_name: error
```
