<?php

class Mapping {

    public function __constructs() {}

    /**
     * Create a new alias for an URL and return this alias
     *
     * @param string $url
     * @return string
     */
    public function newAlias($url) {}

    /**
     * Change an existing alias
     *
     * @param string $alias
     * @param string $url
     */
    public function setUrl($alias, $url) {}

    /**
     * Retrieve an URL for an specific alias
     *
     * @param string $alias
     * @return string
     */
    public function getUrl($alias) {}

    /**
     * Deletes an existing alias
     *
     * @param string $alias
     */
    public function deleteAlias($alias) {}

    /**
     * Retrieves the ten most recent mappings
     *
     * @return array<string,string>
     */
    public function getMostRecentMappings() {}

    /**
     * Retrieves the mappings for the provieded aliases
     *
     * @param string[] $aliases
     * @return array<string,string>
     */
    public function getUrls($aliases) {}
}

?>