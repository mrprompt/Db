<?php
/**
 * Db
 *
 * Acesso a Banco de dados utilizando PDO e XML
 *
 * @category   Database
 * @package    DbConnection
 * @subpackage Db
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2012
 * @license    BSD
 */
namespace DbConnection;

/**
 * @see Exception
 *
 */
require_once __DIR__ . '/DbException.php';

/**
 * @see Metadata
 */
require_once __DIR__ . '/Metadata.php';

/**
 * Main Class
 *
 * @category   Database
 * @package    DbConnection
 * @subpackage Db
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2012
 * @license    BSD
 */
class Db extends \PDO
{
    /**
     * Objeto da conexão
     *
     * @var PDO object
     */
    protected $_objDb;

    /**
     * Nome da conexão utilizada
     *
     * @var string
     */
    protected $_connection = 'default';

    /**
     * Objeto do SimpleXml
     *
     * @var SimpleXmlElement
     */
    protected $_objXml;

    /**
     * Arquivo XML com as queries
     *
     * @var string
     */
    protected $_strXml = null;

    /**
     * A query executada
     *
     * @var string
     */
    protected $_sql = null;

    /**
     * Construtor
     *
     * @param string $metadata
     */
    public function __construct($metadata = null)
    {
        $this->_strXml = $metadata;
        $this->_objXml = new Metadata($this->_strXml);
    }

    public function setSql($_sql)
    {
        $this->_sql = $_sql;

        return $this;
    }

    /**
     * Retorna o SQL selecionado pelo parâmetro $strMetodo
     *
     * @param   string $strMetodo O nome do SQL a ser chamado no metadata
     * @return  string
     */
    public function getSql($strMetodo = null)
    {
        $query = $this->_objXml->getSql($strMetodo);

        $this->_sql         = $query[0];
        $this->_connection  = $query[1];

        return $this->_sql;
    }

    /**
     * Efetua a conexão ao banco
     *
     * @return \PDO
     * @throws DbException
     */
    public function getConnection($connection = 'default')
    {
        try {
            $this->_connection = $connection;

            if (empty( $this->_objDb[ $this->_connection ])
                    || !$this->_objDb[ $this->_connection ] instanceof \PDO) {
                $conn  = $this->_objXml->getConnection($this->_connection);
                $parm  = array(
                    \PDO::ATTR_ERRMODE   => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_CASE      => \PDO::CASE_NATURAL
                );

                $this->_objDb[ $this->_connection ] = new \PDO(
                    "{$conn['driver']}:{$conn['dsn']}",
                    $conn['user'],
                    $conn['password'],
                    $parm
                );
            }

            return $this->_objDb[ $this->_connection ];
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * Call envia uma chamada ao método SQL descrito no arquivo XML de
     * Metadata, repassando os parâmetros passados via array
     *
     * @param   string $metodo A consulta a ser chamada, no node 'name'
     * @param   array  $parametros Um array com os parâmetros da consulta
     * @return  array
     */
    public function __call($metodo=null, $parametros=null)
    {
        try {
            if (is_array($parametros) && !empty($parametros[0])) {
                $parametros = $parametros[0];
            }

            $strSql   = $this->getSql($metodo);
            $objConn  = $this->getConnection()
                             ->prepare($strSql);
            $objConn->execute($parametros);

            return $objConn;
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
