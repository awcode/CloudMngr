Cloud Mngr
==============

**A control panel system for building and controlling your cloud hosted infrastructure**

Currently this is being built for Amazon Web services but will also be supporting Google Compute Engine soon.

The goal is a simple to use interface that anyone can use to build a load balancing, self scaling, enterprise grade hosting infrastucture without needing to be a linux guru.
Preset configs out of the box to get anyone started in minutes, plus the modular and configuration options for sys-ops to take things to even higher levels.

Installation / Usage
--------------------
Now using composer for dependencies

1. Download the [`composer.phar`](https://getcomposer.org/composer.phar) executable or use the installer.

    ``` sh
    $ curl -sS https://getcomposer.org/installer | php
    ```
2. Run Composer: `php composer.phar install`
3. Enter your AWS IAM Security Credentials inside data/config.sample.php and rename to config.php

Version History
---------------
Feb 26th 2015- version 0.0.2 - base platform ready, fully modular and now using composer (still lacking core functionality)
Oct 23rd 2014- version 0.0.1 - rough, raw and incomplete - not yet production ready (or fully functional)!

Developers
----------
Mark Walker / AWcode
