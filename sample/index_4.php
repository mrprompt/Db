<?php
require_once __DIR__ . '/../src/Metadata.php';

try {
    $obj = new DbConnection\Metadata(__DIR__ . '/../config/queries.xml');

    $conn = $obj->getConnection('default');
    echo 'conecção: ' . PHP_EOL;
    var_dump($conn);
    echo PHP_EOL;

    echo 'Buscando SQL' . PHP_EOL;
    $sql = $obj->getSql('dataAtual');
    var_dump($sql) . PHP_EOL;
    echo PHP_EOL;

    echo PHP_EOL;
} catch (\DbConnection\MetadataException $e) {
    echo 'Erro: ' . $e->getMessage() . PHP_EOL;
}