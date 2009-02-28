<?php
// http://www.php.net/manual/en/reserved.keywords.php
$stringsFromPhpManual['keywords'] = 'abstract (as of PHP 5)   and   array()   as   break 
  case   catch (as of PHP 5)    cfunction (PHP 4 only)   class   clone (as of PHP 5) 
  const   continue   declare   default   do 
  else   elseif   enddeclare   endfor   endforeach 
  endif   endswitch   endwhile   extends   final (as of PHP 5) 
  for   foreach   function   global   goto (as of PHP 5.3) 
  if   implements (as of PHP 5)   interface (as of PHP 5)   instanceof (as of PHP 5) 
  namespace (as of PHP 5.3)   new    old_function (PHP 4 only)   or   private (as of PHP 5) 
  protected (as of PHP 5)   public (as of PHP 5)   static   switch   throw (as of PHP 5) 
  try (as of PHP 5)   use   var   while   xor';
$stringsFromPhpManual['compileTimeConstants'] = '__CLASS__   __DIR__ (as of PHP 5.3)   __FILE__   __FUNCTION__   __METHOD__ 
  __NAMESPACE__';
$stringsFromPhpManual['languageConstructs'] = 'die()   echo()   empty()   exit()   eval() 
  include()   include_once()   isset()   list()   require() 
  require_once()   return()   print()   unset()';
// http://www.php.net/manual/en/reserved.classes.php
$stringsFromPhpManual['specialClasses'] = 'self 
  
parent';
// http://www.php.net/manual/en/language.oop5.magic.php
$stringsFromPhpManual['magicMethods'] = str_replace(' and ', ', ', '__construct, __destruct, __call, __callStatic, __get, __set, __isset, __unset, __sleep, __wakeup, __toString, __invoke, __set_state and __clone');

// parse stings from PHP Manual into arrays
$reservedWords = array();
foreach ($stringsFromPhpManual as $key => $stringFromPhpManual) {
    $reservedWords[$key] = preg_split('/,?\s*(\([^)]*\))?\s+/', $stringFromPhpManual);
}

// get declared classes of the current PHP interpreter
$reservedWords['declaredClasses'] = get_declared_classes();

// output the list
echo '$reservedWords = ', var_export($reservedWords, true);
