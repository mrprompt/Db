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
    $foo        = new Foo($db);
    $foo->nome  = 'model nome: ' . uniqid();
    echo 'Inserido ID: # ' . $foo->save() . PHP_EOL;
    echo PHP_EOL;

    echo 'listando todos pelo fetchAll' . PHP_EOL;
    var_dump($foo->fetchAll());

    echo PHP_EOL;
} catch (\DbConnection\TableException $e) {
    echo 'MODEL: ' . $e->getMessage() . PHP_EOL;
} catch (\DbConnection\DbException $e) {
    echo 'DB: ' . $e->getMessage() . PHP_EOL;
}