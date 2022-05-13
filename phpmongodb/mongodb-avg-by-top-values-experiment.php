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
          //sorting the eurmwh, -1 ascending and 1 descending
          ['$sort' => ['eurmwh' => 1]],
          //limits the amount of input rows
          ['$limit' => 100],
          //grouping the rows, place them inside a array and then preform the avg operation
          ['$group' => [ '_id' => '',
            'newvalues' => ['$push' => ['$min' => '$eurmwh']],
            'avg' => ['$avg' => '$eurmwh']
            ]
          ],
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
    $file = fopen('Time-for-avg-by-top-values-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
      //put data into csv file
      fputcsv ($file, (array)$line);
    }
    fclose($file);

    foreach($document as $doc){
        var_dump($doc);
    }
?>
