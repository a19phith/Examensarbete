<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $timestampList = [];

    //Get a random document from the record with the operator $sample
    for ($i=0; $i < 2 ; $i++) { 
        //Start time
        $time_start = microtime(true);

        $document = $elprisercollection-> aggregate([
            [ '$sample' => ['size' => 1] ]
        ]);

        $time_end = microtime(true);

        //The time for the insert
        $time = $time_end - $time_start;
        
        //Push in the time in the array
        array_push($timestampList, $time);
        
    }
    //Create a CSV file
    $file = fopen('Time-for-random-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
        //put data into csv file
        fputcsv ($file, (array)$line);
    }
    fclose($file);

    foreach($document as $doc){
        var_dump($doc);
    }
?>