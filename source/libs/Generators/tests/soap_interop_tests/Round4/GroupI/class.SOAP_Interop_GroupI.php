<?php
/**
 * @webservice
 */
class SOAP_Interop_GroupI {
    
    /**
     * @webmethod
     * @param string $inputString
     * @return string
     */
    function echoString($inputString = '')
    {
        if (empty($inputString)) {
            return '';
        }
        return $inputString;
    }
    
    /**
     * @webmethod
     * @param integer $inputInteger
     * @return integer
     */
    function echoInteger($inputInteger)
    {
        return $inputInteger;
    }
    
    /**
     * @webmethod
     * @param Float $inputFloat
     * @return Float
     */
    function echoFloat($inputFloat)
    {
        return $inputFloat;
    }
    
    /**
     * @webmethod
     * @return void
     */
    function echoVoid()
    {
    }  
    
    /**
     * @webmethod
     * @param Integer[] $inputIntegerMultiOccurs
     * @return Integer[]
     */
    function echoIntegerMultiOccurs($inputIntegerMultiOccurs)
    {
        return $inputIntegerMultiOccurs;
    }
    
    /**
     * @webmethod
     * @param Float[] $inputFloatMultiOccurs
     * @return Float[]
     */
    function echoFloatMultiOccurs($inputFloatMultiOccurs)
    {
        return $inputFloatMultiOccurs;
    }
    
    /**
     * @webmethod
     * @param string[] $inputStringMultiOccurs
     * @return string[]
     */
    function echoStringMultiOccurs($inputStringMultiOccurs)
    {
        return $inputStringMultiOccurs;
    }
    
    /**
     * @webmethod
     * @param boolean $boolean
     * @return boolean
     */
    function echoBoolean($boolean)
    {
        return $boolean;
    }
    
    /**
     * @webmethod
     * @param string $input
     * @return string
     */
    function echoAnyType($input)
    {
        return $input;
    }
    
}
?>