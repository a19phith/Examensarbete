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

    //timestamp array
    $timestampList = [];

    //How many times the get data iterates
    for ($i=0; $i < 50 ; $i++) { 
        //Start time
        $time_start = microtime(true);
        
        //Get the row with the lowest EURMWh
        //$sql = "SELECT * FROM elpriser WHERE EURMWh = (SELECT MIN(EURMWh) FROM elpriser)";

        //Get random rows 
        $sql = "SELECT * FROM elpriser ORDER BY RAND() LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<br>". $row["distrikt"]. " ". $row["EURMWh"]. " " . $row["datum"] . " " . $row["startHour"]. " - " . $row["endHour"]."<br>";
            }
        } else {
            echo "0 results";
        }

        $time_end = microtime(true);

        //The time for the insert
        $time = $time_end - $time_start;

        //Push in the time in the array
        array_push($timestampList, $time);

    }

    //Create a CSV file
    $file = fopen('Time-for-show-mysql.csv', 'w');
    foreach ($timestampList as $line) {
        //put data into csv file
        fputcsv ($file, (array)$line);
    }
    fclose($file);
    $conn->close();

?>