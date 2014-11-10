# chdphp #

Handle of characters transfer by wowtransfer.com


## Desctription ##

Application divides in two parts:

1. Current area - this is part for users (players).

2. Admin - this is part for administrations, allow create, delete and update transfers, create and delete the characters.


## Requirements

* PHP 5.3+
* MySQL 5.1+


## Dependenses ##

### Installator

* jquery-2.1.1
* bootstrap-3.2.0

### Application

* Yii framework version 1.15+
* yiibooster-4.0.1



## Roles ##

1. user - Simple users (players).
2. moderator - Allow check the transfers, create and delete the characters.
3. admin - Full privileges.


## sitemap ##

index.php

* /site/login   - login
* /site/logout  - logout

* /transfers/           - my transfers
* /transders/create     - create transfer
* /transfers/id         - view transfer
* /transfers/update/id  - update transfer's attributes
* /transfers/delete/id  - delete transfer

admin.php

* /transfers/           - view all transfers
* /transfers/id         - view transfer
* /transfers/update/id  - update transfer's attributes
* /transders/delete/id  - delete transfer
* /transfers/char/id    - handle of character
* /transfers/createchar/id  - create character by transfer's id
* /transfers/deletechar/id  - delete character by transfer's id

* /char/create/id       - create character by transfer's id
* /char/delete/id       - delete character by transfer's id
* /char/view/id         - view character's info


## TODO ##

* Defence from infinite login: give 5 attempts on 15 minutes
* Add multilanguages
* convert all icons to one image and make styles