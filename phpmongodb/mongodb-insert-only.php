<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $daysPerMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30 ,31);
    $startHour = -1;
    $endHour = 0;
    $day = 0;
    $month = 0;
    $year = 2022;

    //How many months the script inserts
    for ($m=0; $m < 6; $m++) {
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
                //new MongoDB\BSON\UTCDateTime( (int) $timestamp * 1000 );

                $insertOneResult = $elprisercollection->insertOne(
                    [
                        'eldistrikt' => 'sys',
                        'eurmwh' => $eurmwh,
                        'datum' => new MongoDB\BSON\UTCDateTime(strtotime("$day-$month-$year")*1000),
                        'starthour' => $convertStartHour,
                        'endhour' => $convertEndHour
                    ]
                );

            }
            $startHour = -1;
            $endHour = 0;
        }
        $day = 0;
    }

    printf("inserted %d documents", $insertOneResult->getInsertedCount());

    var_dump($insertOneResult->getInsertedId());
    echo "done";

?>
