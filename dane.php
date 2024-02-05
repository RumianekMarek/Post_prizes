<?php

function check_database($tableName) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "local";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return false;
    }
    return $conn;
}

function table_exists($tableName) {
    $conn = check_database($tableName);
    $tableExistsQuery = "SHOW TABLES LIKE '$tableName'";
    $tableExistsResult = $conn->query($tableExistsQuery);

    return $tableExistsResult->num_rows > 0;
}

function add_to_table($tableName, $content){
    if(table_exists($tableName)){
        $conn = check_database($tableName);
        $values = implode(',', array_map(function ($item) use ($conn) {
        $id = $item[0];
        $fileData = $conn->real_escape_string($item[1]);
        return "($id, '$fileData')";
        }, $content));
    
        $insertQuery = "INSERT INTO $tableName (zone_number, price) VALUES $values";
    
        if ($conn->query($insertQuery) === true) {
            echo "Dane zostały dodane do bazy danych.<br>";
        } else {
            echo "Błąd dodawania danych: " . $conn->error . "<br>";
        }
    } else {
        return false;
    }
}

function fetch_data($tableName, $number = 'all') {
    if(table_exists($tableName)){
        $conn = check_database($tableName);
        if ($number == 'all'){
            $query = "SELECT * FROM $tableName";
            $counter = 0;
        } else {
            $query = "SELECT * FROM $tableName WHERE zone_number = $number";
            $counter = 0;
        }

        $result = $conn->query($query);
        if ($result) {
            $data = array();

            while (($row = $result->fetch_assoc()) && $counter < 86) {          
                $data[] = $row;
                $counter++;
            }
            return $data;
        } else {
            echo "Błąd zapytania: " . $conn->error;
            return false;
        }
    } else {
        return false;
    }
}
?>