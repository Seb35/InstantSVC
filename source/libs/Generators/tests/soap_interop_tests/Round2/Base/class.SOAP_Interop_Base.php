<?php
/**
 * @webservice
 */
class SOAP_Interop_Base {
   /**
    * @webmethod   
	* @param string $inputString
	* @return string
	*/
    function echoString($inputString)
    {
      return $inputString;
    }
   /**
    * @webmethod
	* @param string[] $inputStringArray
	* @return string[]
	*/
    function echoStringArray($inputStringArray)
    {
      return $inputStringArray;
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
	* @param integer[] $inputIntegerArray
	* @return integer[]
	*/
    function echoIntegerArray($inputIntegerArray)
    {
      return $inputIntegerArray;
    }
    
   /**
    * @webmethod
	* @param float $inputFloat
	* @return float
	*/
    function echoFloat($inputFloat)
    {
      return $inputFloat;
    }
    
   /**
    * @webmethod
	* @param float[] $inputFloatArray
	* @return float[]
	*/
    function echoFloatArray($inputFloatArray)
    {
      return $inputFloatArray;
    }

/*
function echoStruct($inputStruct)
{
  return $inputStruct;
}

function echoStructArray($inputStructArray)
{
  return $inputStructArray;
}//*/

   /**
    * @webmethod
	* @return void
	*/
    function echoVoid()
    {
      return NULL;
    }

/*
function echoBase64($b_encoded)
{
  return $b_encoded;
}

function echoDate($timeInstant)
{
  return $timeInstant;
}

function echoHexBinary($hb)
{
  return $hb;
}

function echoDecimal($dec)
{
  return $dec;
}//*/
   /**
    * @webmethod
	* @param boolean $inputBoolean
	* @return boolean
	*/
    function echoBoolean($inputBoolean)
    {
      return $inputBoolean;
    }

}
?>