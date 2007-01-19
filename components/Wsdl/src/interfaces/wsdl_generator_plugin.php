<?php
/**
 * @package    Wsdl
 * @author     Gregor Gabrysiak <gregor_abrak at web dot de>
 * @author     Falko Menge <mail@falko-menge.de>
 * @copyright  2007 InstantSVC Team
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
/**
 * This interface is used for plugins, which are able to sort out all methods
 * which are not supposed to be published. Also, the plugins should be able
 * enrich the methods with documentation.
 */
interface isvcWsdlGeneratorPlugin
{
    /**
     * filters methods to be published in WSDL
     * @param ReflectionMethod[] $methods list of method objects
     * @return ReflectionMethod[] filtered list of method objects
     */
    public function getPublishedMethods($methods);
    
    /**
     * provides an array with documentation for each method
     * @param ReflectionMethod[] $methods - Liste mit ReflectionMethod-Objekten
     * @return array(string=>string) documentation texts with method name as key
     */
    public function getUserComments($methods);
}
?>