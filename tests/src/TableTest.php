<?php
namespace DbConnection;

require_once 'PHPUnit/Autoload.php';
require_once __DIR__ . '/../../src/Table.php';

/**
 * Test class for Table.
 * Generated by PHPUnit on 2012-01-04 at 20:34:52.
 */
class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Table
     * @access protected
     */
    protected $_table;

    const METADATA_PATH = '../config/queries.xml';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_table = new Table(self::METADATA_PATH);
    }

    public function testGetValuesExists()
    {
        $this->assertTrue(method_exists($this->_table, '_getValues'));
    }

    public function testSaveExists()
    {
        $this->assertTrue(method_exists($this->_table, 'save'));
    }

    public function testFetchAllExists()
    {
        $this->assertTrue(method_exists($this->_table, 'fetchAll'));
    }

    public function testFetchRowExists()
    {
        $this->assertTrue(method_exists($this->_table, 'fetchRow'));
    }
}
