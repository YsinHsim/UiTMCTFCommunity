<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'CTFComm';

    //Connect to the database
    $conn = new mysqli();
    $conn -> connect($host, $user, $password, $database);

    //If error, view error message...
    if (mysqli_connect_errno()) {
        exit('Connection failed: '. mysqli_connect_error());
    }
?>
