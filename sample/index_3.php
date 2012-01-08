<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/Table.php';

/**
 * Model para a tabela Foo
 *
 */
class Foo extends \DbConnection\Table
{
    protected $_table = 'Foo';
}

try {
    $db = new DbConnection\Db(__DIR__ . '/../config/queries.xml');

    // chamando a função com o call
    echo 'Data do banco: ' . $db->dataAtual()
                                ->fetchObject()
                                ->data
                           . PHP_EOL
                           . PHP_EOL;
} catch (\DbConnection\TableException $e) {
    echo 'MODEL: ' . $e->getMessage() . PHP_EOL;
} catch (\DbConnection\DbException $e) {
    echo 'DB: ' . $e->getMessage() . PHP_EOL;
}