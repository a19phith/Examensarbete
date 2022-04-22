<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $timestampList = [];

      for ($t=0 ; $t < 100 ; $t++) {
      //Start time
      $time_start = microtime(true);

      for ($i=0; $i < 50; $i++) {
        $document = $elprisercollection-> aggregate([
            //group the data by day
            [
                '$group' => [
                '_id' => '$datum',
                "EURMWh-avg" => ['$avg' => '$eurmwh']
                ]
            ],
            //get random row from the database
            [
                '$sample' => ['size' => 1]
            ]
        ]);
      }
        //End time
        $time_end = microtime(true);

        //The time for the insert
        $time = ($time_end - $time_start)*1000;


        //Push in the time in the array
        array_push($timestampList, $time);
    }

    //Create a CSV file
    $file = fopen('Time-for-avg-by-day-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
      //put data into csv file
      fputcsv ($file, (array)$line);
    }
    fclose($file);

    foreach($document as $doc){
        var_dump($doc);
    }
?>
