Stepfs for getting the InstantSVC snapshot to work

Requirements:
    PHP => 5.2.0 (http://www.php.net/)
        required extensions:
            Reflection
            SOAP
    options in php.ini:
        session.use_cookies = 1      # required for admin tool
        soap.wsdl_cache_enabled = 0  # recommended for development servers
    MySQL (for the admin tool and when using the Username Token Profile) (http://www.mysql.com/)
You further need (read below how to apply it):
    Smarty Template Engine (http://www.smarty.net/)
    AdoDB for PHP (http://adodb.sourceforge.net/)


Now, follow the instructions (as root).

1. Create a directory under your web server document root, e.g., "instantsvc".
The following assumes that the root is "/var/www".
mkdir --parent /var/www/instantsvc

This directory will contain the complete InstantSVC installation, including the 
InstantSVC code itself, Smarty, and AdoDB.

Further, create another directory for the services directly in your document
root, e.g., "services".
mkdir /var/www/services


2. Create the corresponding subdirectories.
mkdir /var/www/instantsvc/adodb
mkdir /var/www/instantsvc/smarty
mkdir /var/www/instantsvc/trunk

"trunk" will later contain InstantSVC itself.


3. Download Smarty and AdoDB and extract/copy the following files in the corresponding directories.
content of Smarty/libs => /var/www/instantsvc/smarty
content of adodb5      => /var/www/instantsvc/adodb


4. Check out instantsvc trunk, do not download a snapshot or something similar
from the sourceforge homepage. If you plan to commit something, you might want
to exchange "export --force" by "checkout"
svn export --force https://instantsvc.svn.sourceforge.net/svnroot/instantsvc/trunk /var/www/instantsvc/trunk 


5. If neccessary change the constants in
    instantsvc/trunk/source/tools/admin-tool/admin-tool-config.php
    instantsvc/trunk/libs/config/config.php


6. Set write permissions for:
chmod o+w /var/www/instantsvc/trunk/source/tools/admin-tool/admin-tool-log.txt
chmod o+w /var/www/instantsvc/trunk/source/tools/admin-tool/dbconfig.php
chmod o+w /var/www/instantsvc/trunk/source/templates_c
chmod o+w /var/www/instantsvc/trunk/source/templates_c/admin-tool
chmod o+w /var/www/services


7. Install mysql, create a database schema, e.g. named 'instantsvc', in MySQL
You may also want to create a separate MySQL user for InstantSVC
with permissions to access the database you just created.

apt-get install mysql-server mysql-client
mysql -u root -p -e "create database instantsvc"
(enter your root password)


8. Point your browser to http://localhost/instantsvc/trunk/source/tools/admin-tool/setup.php
Enter the database credentials (esp. the root password or the special instantsvc
user if you created one).
The installation programm will import 
instantsvc/trunk/source/tools/admin-tool/sql/instantsvc.sql
into the database and adjust the database connection settings in
instantsvc/trunk/source/tools/admin-tool/dbconfig.php

In order to use authentication via WS-Security Username Token Profile you have to import
    instantsvc/trunk/source/libs/UserTokenProfile/sql/usertokenstorage.sql
into your database and configure the database connection settings in lines 87-91 of
    instantsvc/trunk/source/libs/UserTokenProfile/CheckUserDB.php
It may be also neccessary to adjust the constant ADODB_DIR in line 21.
After that you have to change the method getPassword,
so that it returns the password of a given user from your application.

WARNING:
It is strongly advised to restrict access to the directory
    instantsvc/trunk/source/tools/admin-tool
for example by using the HTTP Authentication standard as described in RFC 2617.
This directory contains the Web-based adminstration tools of InstantSVC that
allow for scanning arbitrary directories on you server for PHP classes as well
as generating Web Services to make these classes accessible for the public,
i.e., executing the PHP code remotely. Consult the documentation of your
webserver for information on how HTTP Authentication can be configured.
