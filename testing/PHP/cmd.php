<?php

$descriptorspec = array(
   0 => array('pipe', 'r'),
   1 => array('pipe', 'w'),
   2 => array('pipe', 'r')
);


$process = proc_open('php', $descriptorspec, $pipes);

if (is_resource($process)) {
    $array = array('test' => 'foo', 4 => 'bar');
    $phpCommands = '<?php
                        require_once "inc.php";
                        Test::output('.var_export($array, true).');
                    ?>';


    fwrite($pipes[0], $phpCommands);
    fclose($pipes[0]);

    echo stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]); //
    // It is important that you close any pipes before calling
    // proc_close in order to avoid a deadlock
    $return_value = proc_close($process);

echo "command returned $return_value\n";
}




/*
//$array = array('test' => 'foo', 4 => 'bar');

$cmd = 'php -r "require_once inc.php; Test::output('.escapeshellarg(serialize($array)).');"';
echo $cmd;
exec($cmd);
*/
//test: spawn console windows
/*for ($i = 0; $i < 2; $i++) {
    exec('start /B C:\programme\php5\php.exe -r "var_dump($_ENV);"', $array, $return );
    //var_dump($array);
    //var_dump($return);


}*/
?>