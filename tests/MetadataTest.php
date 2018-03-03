<?php
namespace DbConnection;

use DbConnection\Metadata as Metadata;

/**
 * Test class for Metadata.
 * Generated by PHPUnit on 2012-01-06 at 04:53:44.
 */
class MetadataTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Metadata
     */
    protected $_obj;

    const METADATA_PATH = __DIR__ . '/../config/queries.xml';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_obj = new Metadata(self::METADATA_PATH);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    public function testConstructExists()
    {
        $this->assertTrue(method_exists($this->_obj, '__construct'));
    }

    public function testSetXmlReturnExceptionFileNotFound()
    {
        $this->setExpectedException('DbConnection\MetadataException');
        new Metadata();
    }

    public function testSetXmlExists()
    {
        $this->assertTrue(method_exists($this->_obj, 'setXml'));
    }

    public function testSetXmlReturnObject()
    {
        $object = is_object($this->_obj->setXml(self::METADATA_PATH));
        $this->assertTrue($object);
    }

    public function testSetGetXmlExists()
    {
        $this->assertTrue(method_exists($this->_obj, 'getXml'));
    }

    public function testGetConnectionExists()
    {
        $this->assertTrue(method_exists($this->_obj, 'getConnection'));
    }

    public function testGetConnectionReturnObject()
    {
        $this->assertTrue(is_object($this->_obj->getConnection('default')));
    }

    public function testGetDefaultConnectionExists()
    {
        $this->assertTrue(method_exists($this->_obj, 'getDefaultConnection'));
    }

    public function testGetDefaultConnectionReturnObject()
    {
        $this->assertTrue(is_object($this->_obj->getDefaultConnection()));
    }

    public function testGetSqlExists()
    {
        $this->assertTrue(method_exists($this->_obj, 'getSql'));
    }

    public function testGetSqlReturnArray()
    {
        $this->assertTrue(is_array($this->_obj->getSql('dataAtual')));
    }
}