Steps for getting the InstantSVC snapshot to work

Requirements:
    PHP => 5.2.0 (http://www.php.net/)
        required extensions:
            Reflection
            SOAP
    options in php.ini:
        session.use_cookies = 1      # required for admin tool
        soap.wsdl_cache_enabled = 0  # recommended for development servers
    Smarty Template Engine (http://www.smarty.net/)
    AdoDB for PHP (http://adodb.sourceforge.net/)
    MySQL (for the admin tool and when using the Username Token Profile) (http://www.mysql.com/)

Extract the following files into the document root of your webserver:
    Smarty/libs => instantsvc/smarty
    adodb5      => instantsvc/adodb
    snapshot    => instantsvc/snapshot

If neccessary change the constants in
    instantsvc/snapshot/source/tools/admin-tool/admin-tool-config.php
    instantsvc/snapshot/libs/config/config.php

Set write permissions for:
    instantsvc/snapshot/source/tools/admin-tool/admin-tool-log.txt
    instantsvc/snapshot/source/tools/admin-tool/dbconfig.php
    instantsvc/snapshot/source/templates_c
    instantsvc/snapshot/source/templates_c/admin-tool
    services => empty directory in the document root of your webserver

Create a database schema, e.g. named 'instantsvc', in MySQL
You may also want to create a separate MySQL user for InstantSVC
with permissions to access the database you just created.

Point your browser to http://localhost/instantsvc/snapshot/source/tools/admin-tool/setup.php
    The installation programm will import
        instantsvc/snapshot/source/tools/admin-tool/sql/instantsvc.sql
    into the database and adjust the database connection settings in
        instantsvc/snapshot/source/tools/admin-tool/admin-tool-db.php

In order to use authentication via WS-Security Username Token Profile you have to import
    instantsvc/snapshot/source/libs/UserTokenProfile/sql/usertokenstorage.sql
into your database and configure the database connection settings in lines 87-91 of
    instantsvc/snapshot/source/libs/UserTokenProfile/CheckUserDB.php
It may be also neccessary to adjust the constant ADODB_DIR in line 21.
After that you have to change the method getPassword,
so that it returns the password of a given user from your application.
