# Wowtransfer PHP client #

Handle of characters transfer using wowtransfer.com service.


## Desctription ##

Application divides in two parts:

1. Frontend - this is part for users (players).

2. Backend - this is part for administrations, allow create, delete and update transfers, create and delete the characters.

And third simple part is an installer!

## Requirements

* PHP 5.5+
* MySQL 5.1+


## Dependenses ##

### Installator

* jquery-2.1.4
* bootstrap-3.3.4

### Application

* Yii framework version 1.16+
* yiistrap 2.0.3+ extension for Yii
* Twitter bootstrap 3.3.4+

### For developer

use `composer install` or `composer update` commands.

[yiistrap](https://github.com/crisu83/yiistrap/releases),
download extension to `/protected/extensions/yiistrap` directory

Set up `less` in the IDE.



## Installation

This section has three ways

### Subdomain

1. Create the subdomain on the server.
2. Copy and extract an archive to subdomain`s directory.
3. Go to `/install` url.

### Directory

1. Create the directory in the document root.
2. Copy and extract an archive to this directory.
3. Go to `/directory/install` url.

### Symvolic link

1. Create the directory on the server.
2. Create symvolic link to this directory in the document root.
3. Go to `/directory/install` url.


## Updating

This section is not completed.

1. Dowload the latest release from github.
2. Extract an archive to the directory.
3. Copy all files to server, overwrite all.
5. Run configuration migration script
6. Run database migration script

TODO: do it via web interface.

Warning! The master branch is not release. Download only releases.


## Aims

* Simple application, KISS principle.
* Minimum dependences.
* Minimum network data.
* Include installer.
* If service is denied then use default values, don't throw exceptions!


## Roles ##

1. user - Simple users (players).
2. admin - Full privileges.


## Code style ##

[PSR2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md "PSR2")
compatible style.