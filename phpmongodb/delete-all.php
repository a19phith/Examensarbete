<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $deleteResult = $elprisercollection->deleteMany(
        ['eldistrikt' => 'sys']
    );

    printf("Deleted %d documents", $deleteResult->getDeletedCount());
?>