<?php
/**
 * Table
 *
 * @category   Database
 * @package    DbConnection
 * @subpackage Table
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2012
 * @license    BSD
 */
namespace DbConnection;

/**
 * @see Db
 */
require_once __DIR__ . '/Db.php';

/**
 * @see TableException
 */
require_once __DIR__ . '/TableException.php';

/**
 * Main Class
 *
 * @category   Database
 * @package    DbConnection
 * @subpackage Table
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2012
 * @license    BSD
 */
class Table extends Db
{
    /**
     * PDO database connection
     *
     * @var PDO
     */
    protected $_connection;

    /**
     * Table name
     *
     * @var string
     */
    protected $_table;

    /**
     * Construtor
     *
     * @param string $metadata
     */
    public function __construct($metadata = null)
    {
        parent::__construct($metadata);
        $this->_connection = $this->getConnection();
    }

    /**
     * Return the table atributes
     *
     * @return array
     */
    private function _getValues()
    {
        $ref    = new \ReflectionObject($this);
        $pros   = $ref->getProperties(\ReflectionProperty::IS_PUBLIC);
        $result = array();

        foreach ($pros as $pro) {
            false && $pro = new \ReflectionProperty();

            $result[$pro->getName()] = $pro->getValue($this);
        }

        return $result;
    }

    /**
     * Insert a table row
     *
     * @return integer
     * @throws TableException
     */
    public function save()
    {
        try {
            $values = $this->_getValues();

            $sql = sprintf(
                'INSERT INTO `%s` (%s) VALUES(%s)',
                $this->_table,
                implode(
                    ', ',
                    array_keys($values)
                ),
                implode(
                    ', ',
                    array_map(array($this->_connection, 'quote'), $values)
                )
            );

            $this->_connection->query($sql);

            return $this->_connection->lastInsertId();
        } catch (\PDOException $e) {
            throw new TableException($e->getMessage());
        }
    }

    /**
     * List all rows
     *
     * @param mixed $where
     * @return array
     * @throws TableException
     */
    public function fetchAll($where = null)
    {
        try {
            if ($where !== null) {
                $whereFinal = null;

                if (is_string($where)) {
                    $whereFinal = $where;
                }

                if (is_array($where)) {
                    $whereFinal = implode(' AND ', $where);
                }

                $where = "WHERE {$whereFinal}";
            }

            $sql  = "SELECT * FROM `{$this->_table}` {$where}";
            $stmt = $this->_connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new TableException($e->getMessage());
        }
    }

    /**
     * Get a row
     *
     * @param string $where
     * @return array
     * @throws TableException
     */
    public function fetchRow($where = null)
    {
        try {
            if ($where !== null) {
                $whereFinal = null;

                if (is_string($where)) {
                    $whereFinal = $where;
                }

                if (is_array($where)) {
                    $whereFinal = implode(' AND ', $where);
                }

                $where = "WHERE {$whereFinal}";
            }

            $sql  = "SELECT * FROM `{$this->_table}` {$where} LIMIT 1";
            $stmt = $this->_connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchObject();
        } catch (\PDOException $e) {
            throw new TableException($e->getMessage());
        }
    }
}