<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $document = $elprisercollection-> find(
        [],
        [
            //sort the lowest 1 or highest -1 eurmwh 
            'sort' => ['eurmwh' => -1],
            'limit' => 5
        ]
    );
    foreach($document as $doc){
        var_dump($doc);
    }
?>