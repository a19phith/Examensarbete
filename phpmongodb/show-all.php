<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    //get all documents from collection
    $document = $elprisercollection-> find(
        ['eldistrikt' => 'sys']
    );
    foreach($document as $doc){
        var_dump($doc);
    }
?>