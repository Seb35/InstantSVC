<?php
require_once('PHPUnit/Framework/TestCase.php');
require_once('PHPUnit/Framework/TestSuite.php');
require_once('PHPUnit/Extensions/TestSetup.php');

define('MappingTable_PDO_SQLITE', 'sqlite:'.dirname(__FILE__).'/test.sq3');

require_once('../class.MappingTable.php');

class MappingTableTest extends PHPUnit_Extensions_TestSetup
{
    protected $table = NULL;

    protected function setUp()
    {
        $this->table = MappingTable::getInstance();
    }

    protected function tearDown()
    {
        $this->table = NULL;
        unset($this->table);
        unlink(dirname(__FILE__).'/test.sq3');
    }

    public static function suite()
    {
        return new MappingTableTest(
          new PHPUnit_Framework_TestSuite('MappingTableTestSuite')
        );
    }
}

class MappingTableTestSuite extends PHPUnit_Framework_TestCase
{
    public function testInsert()
    {
        $this->table->insertUrl(434, 'ddddd2');
        $url = $this->table->getUrl(434);
        $this->assertEquals('ddddd2', $url);
        $id = $this->table->getId('ddddd2');
        $this->assertEquals(434, $id);
    }

    public function testMostRecent() {
        $map = $this->table->getMostRecentMappings();
        var_dump($map);
        $this->assertTrue(count($map) <= 10);
    }

    public function testCount()
    {
        $count = $this->table->getCount();

        $this->table->insertUrl(44, 'ddddd');

        $newCount = $this->table->getCount();
        $this->assertEquals($count+1, $newCount);

        $this->table->insertUrl(45, 'ddddd');

        $newCount = $this->table->getCount();
        $this->assertEquals($count+2, $newCount);
    }
}
?>