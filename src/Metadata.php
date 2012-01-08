<?php
/**
 * Metadata
 *
 * @category   Database
 * @package    DbConnection
 * @subpackage Metadata
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2012
 * @license    BSD
 */
namespace DbConnection;

/**
 * @see MetadataException
 *
 */
require_once __DIR__ . '/MetadataException.php';

/**
 * Main Class
 *
 * @category   Database
 * @package    DbConnection
 * @subpackage Metadata
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2012
 * @license    BSD
 */
class Metadata
{
    /**
     * SimpleXml Iterator Object
     *
     * @var \SimpleXMLElement
     */
    private $_obj;

    /**
     * The XML file path
     *
     * @var string
     */
    private $_xml;

    /**
     *
     * @param string $xmlPath The XML File
     */
    public function __construct($xmlPath = null)
    {
        $this->setXml($xmlPath);
    }

    /**
     * Set the XML Metadata file
     *
     * @param string $xmlPath The XML file
     * @return SimpleXmlElement
     * @throws MetadataException
     */
    public function setXml($xmlPath)
    {
        if (!file_exists($xmlPath)) {
            throw new MetadataException('Arquivo não encontrado.');
        }

        $this->_xml = $xmlPath;

        if (!$this->_obj instanceof \SimpleXMLElement) {
            $strXml = file_get_contents($this->_xml);

            $this->_obj = new \SimpleXMLElement($strXml);
        }

        return $this->_obj;
    }

    /**
     * Return the XML Metadata File
     *
     * @return string
     */
    public function getXml()
    {
        return $this->_xml;
    }

    /**
     * Recupera os dados de conecção do metadata
     *
     * @param string $name
     * @return array
     * @throws MetadataException
     */
    public function getConnection($name)
    {
        try {
            $conn = $this->_obj->xpath("//connection[@name='{$name}']");

            return $conn[0];
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * Return default connection
     *
     * @return array 
     * @throws MetadataException
     */
    public function getDefaultConnection()
    {
        return $this->getConnection('default');
    }

    /**
     * Retorna o SQL selecionado pelo parâmetro $strMetodo
     *
     * @static
     * @access  public
     * @param   string $alias O nome do SQL a ser chamado no metadata
     * @return  string
     */
    public function getSql($alias = null)
    {
        $query = $this->_obj->xpath("//query[@name='{$alias}']");
        $attr  = $query[0]->attributes();

        if (isset($query[0])) {
            $sql = trim((string)$query[0][0]);

            return array($sql,
                         (string)$attr['connection']);
        } else {
            throw new Exception($alias . ' não encontrado.');
        }
    }
}