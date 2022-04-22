<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $timestampList = [];

    $month = rand (1, 3);
    $day = rand (1, 31);
    $counter = 0;
    //get all documents from collection
    for ($i=0; $i < 100; $i++) {
      //Start time
      $time_start = microtime(true);
      for ($t=0 ; $t < 50 ; $t++) {
        $document = $elprisercollection-> find(
            ['datum' => Date("$day/$month/2022")]
        );
      }


      //End time
      $time_end = microtime(true);

      //The time for the insert
      $time = ($time_end - $time_start)*1000;


      //Push in the time in the array
      array_push($timestampList, $time);
    }

    //Create a CSV file
    $file = fopen('Time-for-search-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
      //put data into csv file
      fputcsv ($file, (array)$line);
    }
    fclose($file);

    foreach($document as $doc){
        var_dump($doc);
        var_dump($counter);

    }
?>
