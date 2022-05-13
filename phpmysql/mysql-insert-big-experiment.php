<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "phpmyadmin";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //timestamp array
    $timestampList = [];

    //How many times the insert and delete iterates
    for ($t=0; $t < 100 ; $t++) {

        $daysPerMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30 ,31);
        $startHour = -1;
        $endHour = 0;
        $day = 0;
        $month = 0;
        $year = 2022;
        $array = [];

        //How many months the script inserts, the number corresponds to amount of months
        for ($m=0; $m < 12; $m++) {
            $month++;
            //How many days the script inserts
            for ($d=1; $d < $daysPerMonth[$m] + 1 ; $d++) {
                $day++;
                for ($h=0; $h < 24 ; $h++) {
                    $startHour++;
                    $endHour++;
                    $eurmwh = rand (35*9, 350*9)/10;

                    //Generate a string of values
                    $string = "('sys', '$eurmwh', '$year/$month/$day','$startHour', '$endHour')";
                    array_push($array, $string);
                    $values = implode(",", $array);

                }
                $startHour = -1;
                $endHour = 0;
            }
            $day = 0;
        }
        //Start time
        $time_start = microtime(true);

        //insert data
        $sql = "INSERT INTO elpriser (distrikt, eurmwh, datum, starthour, endhour) VALUES" . $values;

        if ($conn->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $time_end = microtime(true);

        //The time for the insert
        $time = ($time_end - $time_start)*1000;


        //Push in the time in the array
        array_push($timestampList, $time);

        //Deleteing the data in the table
        $sql = "DELETE FROM elpriser";
        if ($conn->query($sql) === TRUE) {
            echo "Deleting...";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    //Create a CSV file
    $file = fopen('Time-for-insert-big-mysql.csv', 'w');
    foreach ($timestampList as $line) {
        //put data into csv file
        fputcsv ($file, (array)$line);
    }
    fclose($file);

    $conn->close();
?>
