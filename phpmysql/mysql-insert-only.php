<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "pilotstudie";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $daysPerMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30 ,31);
    $startHour = -1;
    $endHour = 0;
    $day = 0;
    $month = 0;
    $year = 2022;
        
    //How many months the script inserts
    for ($m=0; $m < 1; $m++) { 
        //echo "Inserting...";
        $month++;
        //How many days the script inserts
        for ($d=1; $d < $daysPerMonth[$m] + 1 ; $d++) { 
            $day++;
            for ($h=0; $h < 24 ; $h++) { 
                $startHour++;
                $endHour++;
                $eurmwh = rand (35*9, 350*9)/10;

                $sql = "INSERT INTO elpriser (distrikt, eurmwh, datum, starthour, endhour)
                VALUES ('sys', '$eurmwh', '$year/$month/$day',$startHour, $endHour)";

                if ($conn->query($sql) === TRUE) {
                } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                }            
            
            }
            $startHour = -1;
            $endHour = 0;
        }
        $day = 0;
    }

    $conn->close();
?>