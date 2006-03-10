<?php
/**
 * Web tool to check for explicit dependency resolution
 * uses virtual() to get separated php contexts for each file
 * @package    tools
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Explicity Dependency Check</title>
<style>
 html, body {
 	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9pt;
 }

 body {width:600px; margin:auto; background-color:#fff; padding:5px 25px;}

 table, tr {
 	border:1px solid #ccc;
	border-collapse:collapse;
 }

 th {
 	background-color:#C0D7E4;
 }

 td {
 	padding:2px 4px;
 }

 html, .folder {
 	background-color:#F0F0FF;
 }

 .r {
 	text-align:right;
 }

 .warn {
 	background-color:#FCE39A;
 }
 .err {
 	background-color:#FFBFBF;
 }
 img {border:0; vertical-align:middle;}
 .block {padding-left:30px;}
 input {vertical-align:middle;}
</style>
</head>

<body>
<h1>Explicity Dependency Check</h1>
<p>Checks whether all dependencies are given explicitly in code. Uses <tt>virtual()</tt>
 to execute each .php file in a new php context</p>
<form method="post" action="?" style="vertical-align:middle;">
search path: <input type="text" name="path" style="width:300px;" value="../.." /> <input type="submit" />
</form>
<?php



function findPhpFiles($path) {
    $files = array();
    if (is_dir($path)) {
        if ($dir = opendir($path)) {
            while (($file = readdir($dir)) !== false) {
                if ($file != '..' && $file != '.' && $file != '.svn' && $file != 'CVS') {
                    if (is_dir($path.'/'.$file)) {
                        $files = array_merge($files, findPhpFiles($path.'/'.$file));
                    }
                    else {
                        if (strripos($file, '.php') !== false)
                            $files[] = $path.'/'.$file;
                    }
                }
            }
            closedir($dir);
        }
    }
    return $files;
}


if (isset($_REQUEST['path'])) {
    $files = findPhpFiles($_REQUEST['path']);

    foreach ($files as $file) {
        echo "<h3>$file</h3>\n";


        $wd = getcwd();
        virtual($file);
        chdir($wd);

        //$out = ob_get_clean();

        /*if (strlen(trim($out)) > 0) {
            if (stripos($out, 'warning') !== false or stripos($out, 'fatal error')) {

                //echo $out;
            }
        }*/
    }
}
?>

</body>
</html>