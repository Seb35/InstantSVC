Steps for getting the InstantSVC snapshot to work

Requirements:
    PHP => 5.2.0
    options in php.ini:
        session.use_cookies = 1      # required for admin tool
        soap.wsdl_cache_enabled = 0  # recommended for development servers
    Smarty Template Engine
    AdoDB for PHP
    MySQL (for the admin tool and when using the Username Token Profile)

Extract the following files into the document root of your webserver:
    Smarty/libs => instantsvc/smarty
    adodb5      => instantsvc/adodb
    snapshot    => instantsvc/snapshot

define PHP_BIN_PATH in instantsvc/snapshot/source/tools/admin-tool/admin-tool-config.php

write permissions for:
    instantsvc/snapshot/source/tools/admin-tool/admin-tool-log.txt
    instantsvc/snapshot/source/tools/admin-tool/dbconfig.php
    instantsvc/snapshot/source/templates_c
    instantsvc/snapshot/source/templates_c/admin-tool
    services => empty directory in the document root of your webserver

database: create schema 'instantsvc'

Point your browser to http://localhost/instantsvc/snapshot/source/tools/admin-tool/setup.php


In order to use authentication via WS-Security Username Token Profile you have to import
    instantsvc/snapshot/source/libs/UserTokenProfile/sql/usertokenstorage.sql
into your database and configure the database connection settings in lines 87-91 of
    instantsvc/snapshot/source/libs/UserTokenProfile/CheckUserDB.php
It may be also neccessary to adjust the constant ADODB_DIR in line 21.
After that you have to change the method getPassword,
so that it returns the password of a given user from your application.
