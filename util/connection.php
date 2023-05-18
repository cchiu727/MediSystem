<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "medisystem_db_431danielcollin";

// create db connection
if (!$conn = mysqli_connect($hostname, $username, $password, $dbname)) {
    die("Failed to connect to server.\n");
}
