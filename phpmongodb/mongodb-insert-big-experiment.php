<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $timestampList = [];

    //How many times the insert and delete iterates
    for ($t=0; $t < 100 ; $t++) {

        //Start value for the variables
        $daysPerMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30 ,31);
        $startHour = -1;
        $endHour = 0;
        $day = 0;
        $month = 0;
        $year = 2022;
        $array = [];
        $data = [];

        //How many months the script inserts, the number corresponds to amount of months
        for ($m=0; $m < 12; $m++) {
            $month++;
            //How many days the script inserts
            for ($d=1; $d < $daysPerMonth[$m] + 1 ; $d++) {
                $day++;
                for ($h=0; $h < 24 ; $h++) {
                    $startHour++;
                    $endHour++;
                    $convertStartHour = strval($startHour);
                    $convertEndHour = strval($endHour);
                    $eurmwh = rand (35*9, 350*9)/10;
                    $date = new MongoDB\BSON\UTCDateTime(strtotime("$day-$month-$year")*1000);

                    //Generate a array of values
                    $data = array
                    (
                        'eldistrikt' => 'sys',
                        'eurmwh' => $eurmwh,
                        'datum' => $date,
                        'starthour' => $convertStartHour,
                        'endhour' => $convertEndHour
                    );
                    array_push($array, $data);

                }
                $startHour = -1;
                $endHour = 0;
            }
            $day = 0;
        }

        //Start time
        $time_start = microtime(true);
        //insert the array of values
        $insertOneResult = $elprisercollection->insertMany($array);
        //End time
        $time_end = microtime(true);

        //The time for the insert
        $time = ($time_end - $time_start)*1000;


        //Push in the time in the array
        array_push($timestampList, $time);

        //Deleting the data
        $deleteResult = $elprisercollection->deleteMany(
            ['eldistrikt' => 'sys']
        );
    }

    //Create a CSV file
    $file = fopen('Time-for-insert-big-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
        //put data into csv file
        fputcsv ($file, (array)$line);
    }
    fclose($file);

    printf("inserted %d documents", $insertOneResult->getInsertedCount());

    var_dump($insertOneResult->getInsertedIds());
    echo "done";

?>
