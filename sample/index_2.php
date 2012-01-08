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

    // a model
    echo 'Instanciando a classe modelo Foo, ligada a tabela Foo';
    $foo = new Foo($db);

    echo 'Pegando um único registro' . PHP_EOL;
    $retorno = $foo->fetchRow();
    var_dump($retorno);

    echo PHP_EOL;
} catch (\DbConnection\TableException $e) {
    echo 'MODEL: ' . $e->getMessage() . PHP_EOL;
} catch (\DbConnection\DbException $e) {
    echo 'DB: ' . $e->getMessage() . PHP_EOL;
}