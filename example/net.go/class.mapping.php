<?php

require_once(dirname(__FILE__).'/class.MappingTable.php');
require_once(dirname(__FILE__).'/func.hash.php');

class Mapping {

    /**
     * Singleton Instance
     *
     * @var Mapping
     */
    private static $instance;

    /**
     * The Mapping Table
     *
     * @var MappingTable
     */
    private $table;

    /**
     * Constructor of Mapping
     */
    private function __construct() {
        $this->table = MappingTable::getInstance();
    }

    /**
     * Returns instance of a singleton
     *
     * @return Mapping
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Create a new alias for an URL and returns this alias
     *
     * @param string $url
     * @return string
     */
    public function newAlias($url) {
        $id = $this->table->getId($url);
        if ($id != null) {
            return $this->int2alias($id);
        }
        else {
            $id = calculateHash($url, $this->getCount() * 4 + 36);

            //Check for collisions
            $wrongUrl = $this->table->getUrl($id);
            while ($wrongUrl != null) {
                ++$id;
                $wrongUrl = $this->table->getUrl($id);
            }
            $this->table->insertUrl($id, $url);
            return $this->int2alias($id);
        }
    }

    /**
     * @DELETED cause is would lead to inconsitent behavior
     * Change an existing alias
     *
     * @param string $alias
     * @param string $url
     */
    /* public function setUrl($alias, $url) {
        throw new Exception('Not Implemented');
    } */

    /**
     * Retrieve an URL for an specific alias
     *
     * @param string $alias
     * @return string
     */
    public function getUrl($alias) {
        return $this->getUrlById($this->alias2int($alias));
    }

    /**
     * Returns the URL with the given id from the database
     *
     * @param integer $id
     * @return string
     */
    protected function getUrlById($id) {
        return $this->table->getUrl($id);
    }

    /**
     * Deletes an existing alias
     * This method SHOULD NOT be published as web method, because of possible
     * inconsistent behavior like stolen aliases and unexpected redirects
     *
     * @param string $alias
     */
    public function deleteAlias($alias) {
        $this->table->deleteById($this->alias2int($alias));
    }

    /**
     * Retrieves the ten most recent mappings
     *
     * @return array<string,string>
     */
    public function getMostRecentMappings() {
        $result = $this->table->getMostRecentMappings();
        $r = array();
        foreach ($result as $id => $url) {
            $r[$this->int2alias($id)] = $url;
        }
        return $r;
    }

    /**
     * Retrieves the mappings for the provided aliases
     *
     * @param string[] $aliases
     * @return array<string,string>
     */
    public function getUrls($aliases) {
        $result = array();
        foreach ($aliases as $alias) {
            $result[$alias] = $this->getUrl($alias);
        }
        return $result;
    }

    /**
     * Retrieve the count of registered mappings
     *
     * @return integer
     */
    public function getCount() {
        return $this->table->getCount();
    }

    /**
     * Convert from an alias (base36) representation to an int (base10)
     * representation of an integer value
     *
     * @param string $alias
     * @return int
     */
    protected function alias2int($alias) {
        return intval(base_convert($alias, 36, 10));
    }

    /**
     * Convert from an int (base10) representation to an alias (base36)
     * representation of an integer value
     *
     * @param integer $int
     * @return string
     */
    protected function int2alias($int) {
        return base_convert($int, 10, 36);
    }
}

?>