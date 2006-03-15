<?php
require_once 'class.Foo.php';

/**
 * class for testing WSDL generation for methods with different parameter and return types
 * @webservice
 */
class WSDLGeneratorTest {
    /**
     * @webmethod
     * @return string
     */
    public function sayHello() {
        return 'Hello World!';
    }

    /**
     * @webmethod
     * @param int $x
     * @param int $y
     * @return int
     */
    public function Add($x, $y) {
        return $x+$y;
    }

    /**
     * @webmethod
     * @param float[] $array
     * @return float
     */
    public function arraySum($array) {
      $sum = 0;
      if (is_array($array)) {
        $sum = array_sum($array);
      }
      return $sum;
    }   
    /**
     * @webmethod
     * @return Foo
     */
    public function getFoo() {
        $returnValue = new Foo();
	return $returnValue;
    }
    /**
     * @webmethod
     * @param Foo $inputFoo
     * @return Foo[]
     */
    public function duplicateFoo($inputFoo) {
        $returnValue[] = $inputFoo;
        $returnValue[] = $inputFoo;
	return $returnValue;
    }
}
?>
