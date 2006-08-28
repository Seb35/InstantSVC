<?php

if (!defined('MappingTable_PDO_SQLITE'))
    define('MappingTable_PDO_SQLITE', 'sqlite:'.dirname(__FILE__).'/netgo.sq3');

class MappingTable {

    /**
     * Singleton Instance
     *
     * @var MappingTable
     */
    private static $instance;

    /**
     * PHP Database Object
     *
     * @var PDO
     */
    private $db;

    /**
     * Constructor of MappingTable
     */
    private function __construct() {
        $this->db = new PDO(MappingTable_PDO_SQLITE);
        $this->createTable();
    }

    public function __destruct() {
        unset($this->db);
    }

    /**
     * Returns instance of a singleton
     *
     * @return MappingTable
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    protected function createTable() {
        $this->db->exec('CREATE TABLE mapping ('.
                        'id INTEGER NOT NULL PRIMARY KEY, '.
                        'url TEXT NOT NULL, '.
                        'creation INTEGER DEFAULT CURRENT_TIMESTAMP'.
                        ')');
    }

    /**
     * Returns url for given id or null if not in db
     *
     * @param integer $id
     * @return string
     */
    public function getUrl($id) {
        $stmt = $this->db->prepare('SELECT url FROM mapping WHERE id = ?');
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return (isset($row['url']) ? $row['url'] : null);
        }
        return null;
    }

    /**
     * Returns id for given url or null if not in db
     *
     * @param string $url
     * @return integer
     */
    public function getId($url) {
        $stmt = $this->db->prepare('SELECT id FROM mapping WHERE url = ?');
        $stmt->bindParam(1, $url);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return (isset($row['id']) ? $row['id'] : null);
        }
        return null;
    }

    /**
     * Retrieves the ten most recent mappings
     *
     * @return array<integer,string>
     */
    public function getMostRecentMappings() {
        $result = $this->db->prepare('SELECT id, url FROM mapping ORDER BY creation DESC LIMIT 10');
        $r = array();
        foreach ($result as $row) {
            $r[$row['id']] = $row['url'];
        }
        return $r;
    }

    /**
     * Retrieve the count of registered mappings
     *
     * @return integer
     */
    public function getCount() {
        $result = $this->db->query('SELECT count(*) FROM mapping');
        if ($result) {
            var_dump($result);
            $row = $result->fetch();
            var_dump($row);
            return $row[0];
        }
        return 0;
    }

    /**
     * Insert a new url with the given id
     *
     * @param integer $id
     * @param string $url
     */
    public function insertUrl($id, $url) {
        $stmt = $this->db->prepare('INSERT INTO mapping (id, url) VALUES (?, ?)');
        $stmt->execute(array($id, $url));
    }
}
?>