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
    //How many days the script gets the data
    for ($d=1; $d < 100 + 1 ; $d++) {
        //Start time
        $time_start = microtime(true);
        for ($i=0; $i < 50; $i++) {
              $sql= "SELECT avg(EURMWh) FROM (SELECT EURMWh from elpriser order by EURMWh limit 100) as EURMWh";

              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                      echo "<br>".$row["avg(EURMWh)"]. "<br>";
                  }
              } else {
                  echo "0 results";
              }
        }



       $time_end = microtime(true);

        //The time for the insert
        $time = ($time_end - $time_start)*1000;

        //Push in the time in the array
        array_push($timestampList, $time);

    }
    //Create a CSV file
    $file = fopen('Time-for-avg-by-top-values-mysql.csv', 'w');
    foreach ($timestampList as $line) {
        //put data into csv file
        fputcsv ($file, (array)$line);
    }
    fclose($file);

    $conn->close();

?>
