<?php
error_reporting(E_ALL);
require_once(dirname(__FILE__).'/admin-tool-config.php');
require_once(dirname(__FILE__).'/admin-tool-smarty-connect.php');
require_once(dirname(__FILE__).'/readsqldump.php');
require_once(ADODB_DIR.'/adodb.inc.php');

$smarty  = new AdminToolSmartyConnect();

//Seams to be submited
if (isset($_REQUEST['server'])) {
    $dbconfig['server'] = $_REQUEST['server'];
    $dbconfig['user'] = $_REQUEST['user'];
    $dbconfig['password'] = $_REQUEST['password'];
    $dbconfig['database'] = $_REQUEST['database'];

    $db = ADONewConnection('mysql');
    //$db->debug = true;
    $db->Connect($dbconfig['server'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
    $db->SetFetchMode(ADODB_FETCH_ASSOC);

    $queries = PMA_splitSqlFile(file_get_contents(dirname(__FILE__).'/sql/wsdl-db.sql'));

    $cfg = "<?php \nreturn ".var_export($dbconfig, true)."\n?>";
    file_put_contents(dirname(__FILE__).'/dbconfig.php' , $cfg);

    foreach ($queries as $query) {
        $db->Execute($query);
    }
    $smarty->assign('step', 'finished');
}
else {
    $smarty->assign('step', 'unfinished');
}

$smarty->display('admin-tool/admin-tool-setup.tpl');
?>