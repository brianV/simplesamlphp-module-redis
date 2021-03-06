Redis module for simpleSAMLphp
==============================

<!-- {{TOC}} -->

Introduction
------------

The Redis module implements the simpleSAMLphp datastore API, so Redis can be
used for backend storage, i.e. session storage.

Setup
-----

First thing to do is to set up your Redis server(s). This is out side the scope
of this documentation.

Next you must install this module either by obtaining the tarball or by
installing it via composer. The latter is recommended

    composer.phar require vendor/simplesamlphp-module-redis 1.*

This will automatically install "predis/predis" as a dependency for ther
module. If you downloaded the module yourself, remember to add predis/predis as
a dependency in your composer.json.

See https://github.com/simplesamlphp/composer-module-installer for more
information on how to insatll simpleSAMLphp modules via composer.

You can now enable the module by

    touch /var/simplesamlphp/modules/redis/enable

and copy the config file

    cp /var/simplesamlphp/modules/redis/config-templates/module_redis.php /var/simplesamlphp/config

Edit the config file so it fits your setup. The following options can be configured:

`host`
:   The hostname used for your Redis server
`prefix`
:   Prefix of all keys saved in Redis. Default is 'simplasSALMphp'
`lifetime`
:   The maximum tiem a key is stored in Redis. Default is 8 hours

You can now use redis a a valid simpleSAMLphp datastore. Use for session
storage by setting the following in config.php

    'store.type' => 'redis:Redis'
