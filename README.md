# chdphp #

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

* [yiistrap](https://github.com/crisu83/yiistrap/releases),
download extension to `/protected/extensions/yiistrap` directory
* [Twitter bootstrap 3](https://github.com/twbs/bootstrap/releases)
download latest release (twbs/bootstrap) to `/protected/vendor/twbs/bootstrap` directory
* [Phing](https://www.phing.info/trac/wiki/Users/Installation),
download the Phar archive (phing-latest.phar) to `/protected/vendor` directory

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

* Yes, we are use tabs!
