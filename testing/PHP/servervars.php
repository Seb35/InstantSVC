<?php
header('Content-Type: text/plain');

echo '$_SERVER'."\n";
var_dump($_SERVER);
echo '$_ENV'."\n";
var_dump($_ENV);
echo '$_REQUEST'."\n";
var_dump($_REQUEST);
echo 'apache_request_headers()'."\n";
var_dump(apache_request_headers());
echo 'STDIN'."\n";
var_dump(file_get_contents('php://input'));
?>