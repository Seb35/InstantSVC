<?php

class Mixin {
	public function sayWorld() {
		echo 'World!';
	}
}

/**
* @mixin Mixin
*/
class Test {
	public function sayHello() {
		echo 'Hello ';
	}
}

$test = new Test();

$test->sayHello();

$newCode = "echo 'NewHello!!';";
runkit_method_redefine('Test', 'sayHello', '', $newCode, RUNKIT_ACC_PUBLIC);

$test->sayHello();

//$test->sayWorld();

?>