#!/bin/sh
sudo apt-get install cvs patch
sudo apt-get install autoconf2.13 automake libtool bison flex-old re2c libxml2-dev g++ libgtksourceview-dev

mkdir MetaPHP
cd MetaPHP

cvs -d :pserver:cvsread@cvs.php.net:/repository checkout -r PHP_5_2 php5
cvs -d :pserver:cvsread@cvs.php.net:/repository checkout pecl/runkit

#cvs -d :pserver:cvsread@cvs.php.net:/repository checkout php-gtk
wget http://gtk.php.net/do_download.php?download_file=php-gtk-2.0.0beta.tar.gz
tar -xvvf php-gtk-2.0.0beta.tar.gz
mv php-gtk-2.0.0beta php-gtk

cd php5
./buildconf
./configure --enable-maintainer-zts --enable-debug --disable-cgi

make
sudo make install

cd ..
cd pecl/runkit/
phpize
./configure --enable-runkit --enable-runkit-modify --enable-runkit-super --enable-runkit-sandbox

# apply patch
patch < check-null.patch

make
sudo make install

cd ../../
cd php-gtk

./buildconf
./configure --enable-php-gtk --enable-debug --with-sourceview
make
sudo make install
cd ..

echo [PHP] > php.ini
echo extension = php_gtk2.so >> php.ini
echo extension = runkit.so >> php.ini
