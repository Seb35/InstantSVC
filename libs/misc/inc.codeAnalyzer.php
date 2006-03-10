<?php
$cli = (strpos(php_sapi_name(), 'cli') !== false);
if ($cli) {
    if (isset($_SERVER['argv'][1])) {
        $exec = ($_SERVER['argv'][1] == 'exec');
    }
    else {
        $exec = false;
    }
    if (isset($_SERVER['argv'][2])) {
        $inc = $_SERVER['argv'][2];
    }
    else {
        $inc = null;
    }
}
else {
    $exec = (isset($_GET['exec']) and $_GET['exec'] == 'true');
    $inc = (isset($_GET['filename']))?$_GET['filename']:null;
}

if ($exec and $inc != null) {
    require_once('class.codeAnalyzer.php');
    $classes = get_declared_classes();
    require_once($inc);
    $classes = array_diff(get_declared_classes(), $classes);
    echo '#-#-#-#-#';
    echo serialize(CodeAnalyzer::collectCodeSummary($classes));
    echo '#-#-#-#-#';
}
?>