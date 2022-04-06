<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client;

    $elpriserdb = $client->elpriserdb;

    $elprisercollection = $elpriserdb->elprisercollection;

    $timestampList = [];

    //How many times the insert and delete iterates
    for ($t=0; $t < 3 ; $t++) {
        //Start time
        $time_start = microtime(true);

        //Start value for the variables
        $daysPerMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30 ,31);
        $startHour = -1;
        $endHour = 0;
        $day = 0;
        $month = 0;
        $year = 2022;

        //How many months the script inserts, the number corresponds to amount of months
        for ($m=0; $m < 3; $m++) { 
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
            
                    $insertOneResult = $elprisercollection->insertOne(
                        [
                            'eldistrikt' => 'sys', 
                            'eurmwh' => $eurmwh, 
                            'datum' => Date("$day/$month/$year"), 
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
        //End time 
        $time_end = microtime(true);

        //The time for the insert
        $time = $time_end - $time_start;
    
        //Push in the time in the array
        array_push($timestampList, $time);
    
        //Deleting the data
        $deleteResult = $elprisercollection->deleteMany(
            ['eldistrikt' => 'sys']
        );
    }
    
    //Create a CSV file
    $file = fopen('Time-for-insert-mongodb.csv', 'w');
    foreach ($timestampList as $line) {
        //put data into csv file
        fputcsv ($file, (array)$line);
    }
    fclose($file);

    printf("inserted %d documents", $insertOneResult->getInsertedCount());

    var_dump($insertOneResult->getInsertedId());
    echo "done";

?>