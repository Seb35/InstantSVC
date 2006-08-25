<?php

/* Java

public long DJBHash(String str)
   {
      long hash = 5381;

      for(int i = 0; i < str.length(); i++)
      {
         hash = ((hash << 5) + hash) + str.charAt(i);
      }

      return (hash & 0x7FFFFFFF);
   }
CPP

unsigned int DJBHash(const std::string& str)
{
   unsigned int hash = 5381;

   for(unsigned int i = 0; i < str.length(); i++)
   {
      hash = ((hash << 5) + hash) + str[i];
   }

   return (hash & 0x7FFFFFFF);
}
*/

function DJBHash($str) {
    $hash = 5381;

    $length = strlen($str);
    for ($i = 0; $i < $length; ++$i) {
        $hash = (($hash << 5) + $hash) + ord($str{$i});
    }
    return ($hash & 0x7FFFFFFF);
}

?>