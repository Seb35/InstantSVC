<?php
/**
 * This interface is used for plugins, which are able to sort out all methods
 * which are not supposed to be published. Also, the plugins should be able
 * enrich the methods with documentation.
 */
interface isvcWsdlGeneratorPlugin
{
    public function getPublishedMethods($myMethods);
    public function getUserComments($myMethods);   
}
?>