<?php
error_reporting(E_ALL | E_STRICT);
define('PDO_SQLITE', 'sqlite:'.dirname(__FILE__).'/netgo.sq3');

/*foreach ($dbh->query('SELECT * from mapping') as $row) {
     print_r($row);
}*/

/*echo 'Example 1 <br>';
$dbh = new PDO(PDO_SQLITE);
$dbh->exec('CREATE TABLE t1(a INTEGER PRIMARY KEY, b TEXT, c INTEGER NOT NULL DEFAULT CURRENT_TIMESTAMP)');
var_dump($dbh->errorCode());
$dbh->exec('INSERT INTO t1 (b) VALUES(\'123\');');
var_dump($dbh->errorCode());
foreach ($dbh->query('SELECT * from t1') as $row) {
    var_dump($row);
}
*/

echo '<br><br>Example 2 <br>';

try {
    $dbh = new PDO(PDO_SQLITE);
    $dbh->beginTransaction();
    //echo PDO::ATTR_CLIENT_VERSION;
    //var_dump($dbh->errorCode());

    $dbh->exec('CREATE TABLE mapping (alias INTEGER NOT NULL PRIMARY KEY, url TEXT NOT NULL, creation INTEGER DEFAULT CURRENT_TIMESTAMP)');
    var_dump($dbh->errorInfo());
    $dbh->exec('INSERT INTO mapping (alias, url) VALUES (12, \'http://www.tset.de/\');');
    var_dump($dbh->errorCode());
    $dbh->exec('INSERT INTO mapping (alias, url) VALUES (23, \'http://www.tset.de/\');');
    var_dump($dbh->errorCode());
    var_dump($dbh->commit());
    $dbh->beginTransaction();
    foreach ($dbh->query('SELECT * FROM mapping') as $row) {
       print_r($row);
    }
    $dbh->commit();
    $dbh = null;
}
catch (PDOException $e) {
    die($e->getMessage());
}

?>