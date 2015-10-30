# Zend Framework 2 Module for localization

[![Build Status](https://travis-ci.org/detailnet/dfw-locale-module.svg?branch=master)](https://travis-ci.org/detailnet/dfw-locale-module)
[![Coverage Status](https://img.shields.io/coveralls/detailnet/dfw-locale-module.svg)](https://coveralls.io/r/detailnet/dfw-locale-module)
[![Latest Stable Version](https://poser.pugx.org/detailnet/dfw-locale-module/v/stable.svg)](https://packagist.org/packages/detailnet/dfw-locale-module)
[![Latest Unstable Version](https://poser.pugx.org/detailnet/dfw-locale-module/v/unstable.svg)](https://packagist.org/packages/detailnet/dfw-locale-module)

## Introduction
This module contains tools localized applications (based on the [SlmLocale module for ZF2](https://github.com/juriansluiman/SlmLocale)).

## Requirements
[Zend Framework 2 Skeleton Application](http://www.github.com/zendframework/ZendSkeletonApplication) (or compatible architecture)

## Installation
Install the module through [Composer](http://getcomposer.org/) using the following steps:

  1. `cd my/project/directory`
  
  2. Create a `composer.json` file with following contents (or update your existing file accordingly):

     ```json
     {
         "require": {
             "detailnet/dfw-locale-module": "1.x-dev"
         }
     }
     ```
  3. Install Composer via `curl -s http://getcomposer.org/installer | php` (on Windows, download
     the [installer](http://getcomposer.org/installer) and execute it with PHP)
     
  4. Run `php composer.phar self-update`
     
  5. Run `php composer.phar install`
  
  6. Open `configs/application.config.php` and add following key to your `modules`:

     ```php
     'Detail\Locale',
     ```

  7. Copy `vendor/detailnet/dfw-locale-module/config/detail_locale.local.php.dist` into your application's
     `config/autoload` directory, rename it to `detail_locale.local.php` and make the appropriate changes.

## Usage
tbd
