# BEdita I18n Aws plugin

[![Github Actions](https://github.com/bedita/i18n-aws/workflows/php/badge.svg)](https://github.com/bedita/i18n-aws/actions?query=workflow%3Aphp)
[![codecov](https://codecov.io/gh/bedita/i18n-aws/branch/main/graph/badge.svg)](https://codecov.io/gh/bedita/i18n-aws)
[![phpstan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg)](https://phpstan.org)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bedita/i18n-aws/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/bedita/i18n-aws/?branch=main)
[![image](https://img.shields.io/packagist/v/bedita/i18n-aws.svg?label=stable)](https://packagist.org/packages/bedita/i18n-aws)
[![image](https://img.shields.io/github/license/bedita/i18n-aws.svg)](https://github.com/bedita/i18n-aws/blob/main/LICENSE.LGPL)

## Installation

You can install this plugin into your application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require bedita/i18n-aws
```

Note: php version supported is >= 7.4 and < 8.3.

## Amazon Translate

This plugin uses [AWS Translate](https://docs.aws.amazon.com/translate/) to translate texts, via [aws-sdk-php](https://github.com/aws/aws-sdk-php).

Usage example:
```php
use BEdita\I18n\Aws\Core\Translator;

$translator = new Translator();
$translator->setup([
    'profile' => 'your-profile', // the AWS profile
    'region' => 'your-region', // the AWS region
]);
$result = $translator->translate(['Hello world!'], 'en', 'it');
// $result is an array, i.e ['translation' => ['Ciao mondo!']]
```
