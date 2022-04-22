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
            //get a random record from the database
            [
                '$sample' => ['size' => 1]
            ],
            //group the data by week
            [
              '$project' =>[
                'theweek' => ['$week' => '$datum'],
                'eurmwh' => 1
              ]
            ],
            //get the avg eurmwh by week
            [
                '$group' => [
                '_id' => '$theweek',
                'EURMWh-avg' => ['$avg' => '$eurmwh']
              ]
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
    $file = fopen('Time-for-avg-by-week-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
      //put data into csv file
      fputcsv ($file, (array)$line);
    }
    fclose($file);

    foreach($document as $doc){
        var_dump($doc);
    }
?>
