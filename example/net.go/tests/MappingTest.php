<?php
require_once('PHPUnit/Framework/TestCase.php');
require_once('PHPUnit/Framework/TestSuite.php');
require_once('PHPUnit/Extensions/TestSetup.php');

define('MappingTable_PDO_SQLITE', 'sqlite:'.dirname(__FILE__).'/test.sq3');

require_once('../class.mapping.php');

class MappingTest extends PHPUnit_Extensions_TestSetup
{
    /**
     * @var Mapping
     */
    protected $map = NULL;

    protected function setUp()
    {
        if (file_exists(dirname(__FILE__).'/test.sq3')) {
            unlink(dirname(__FILE__).'/test.sq3');
        }
        $this->map = Mapping::getInstance();
    }

    protected function tearDown()
    {
        unset($this->map);
        $this->map = NULL;

        //unlink(dirname(__FILE__).'/test.sq3');
    }

    public static function suite()
    {
        return new MappingTest(
          new PHPUnit_Framework_TestSuite('MappingTestSuite')
        );
    }
}

class MappingTestSuite extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mapping
     */
    //private $map;

    public function testNewAlias() {
        $u1 = 'fsdfsdf';
        $a1 = $this->map->newAlias($u1);
        $a2 = $this->map->newAlias($u1);

        $this->assertEquals($a1, $a2);

        $u1 = 'rtert dfgusdfogu sdfgu sdfgu sodfug osdfug osdufgo sudfgosudfgosufgo';
        $a1 = $this->map->newAlias($u1);
        $a2 = $this->map->newAlias($u1);

        $this->assertEquals($a1, $a2);
    }

    public function testGetUrl() {
        $u1 = 'fsdfdgf sfdg sfdg sdfg sfgsfg';
        $a1 = $this->map->newAlias($u1);
        $u2 = $this->map->getUrl($a1);

        $this->assertEquals($u1, $u2);
    }

    public function testDeleteAlias() {
        $url = 'http://testurl/';
        $a = $this->map->newAlias($url);
        $urlCheck = $this->map->getUrl($a);

        $this->assertEquals($url, $urlCheck, 'Pre-Condition for testDeleteAlias failed. Can not insert URL.');
        $this->assertNotNull($urlCheck);

        $this->map->deleteAlias($a);
        $urlCheck = $this->map->getUrl($a);
        $this->assertNull($urlCheck, 'Delete failed, return value of getUrl should be NULL for non existing URLs');
    }

    public function testGetMostRecentMappings() {
        $u1 = 'http://url1';
        $u2 = 'http://url2';
        $u3 = 'http://url3';
        $this->map->newAlias($u1);
        $this->map->newAlias($u2);
        $this->map->newAlias($u3);

        $map = $this->map->getMostRecentMappings();

        $this->assertContains($u1, $map);
        $this->assertContains($u2, $map);
        $this->assertContains($u3, $map);
    }

    public function testGetUrls() {
        $u1 = 'fffffffffffffffffffffffffff';
        $u2 = 'fffffffffffffffffffffffffffasass';
        $a1 = $this->map->newAlias($u1);
        $a2 = $this->map->newAlias($u2);

        $map = $this->map->getUrls(array($a1, $a2));
        $this->assertEquals(array($a1=>$u1, $a2=>$u2), $map);
    }

    public function testGetCount() {
        $count = $this->map->getCount();
        $this->map->newAlias('dfadf ds fad gh fghgh gh%%%%');
        $this->assertEquals($count+1, $this->map->getCount());

        $this->map->newAlias('dfadf ds fad gh fghgh gh%%44%%');
        $this->assertEquals($count+2, $this->map->getCount());
    }
}
?>