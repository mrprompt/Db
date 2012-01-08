<?php
require_once __DIR__ . '/../src/Db.php';

try {
    $db = new DbConnection\Db(__DIR__ . '/../config/queries.xml');

    echo 'Invocando nó criaFoo como um método' . PHP_EOL;
    $db->criaFoo();
    echo PHP_EOL;

    echo 'Invocando nó insereFoo como um método' . PHP_EOL;
    $db->insereFoo(array('nome' => 'xml nome: ' . uniqid()));
    echo PHP_EOL;

    echo 'Invocando nó listaFoo como um método' . PHP_EOL;
    $retorno = $db->listaFoo();
    $foo     = null;

    while ($foo = $retorno->fetchObject()) {
        echo $foo->nome
             . PHP_EOL;
    }

    echo PHP_EOL;
} catch (\DbConnection\TableException $e) {
    echo 'MODEL: ' . $e->getMessage() . PHP_EOL;
} catch (\DbConnection\DbException $e) {
    echo 'DB: ' . $e->getMessage() . PHP_EOL;
}