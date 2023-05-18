<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "medisystem_db_431danielcollin";

if (!$conn = mysqli_connect($hostname, $username, $password)) {
    die("Failed to connect to server.\n");
}


// database does not exist, create it and tables
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

if (!mysqli_query($conn, $sql)) {
    die("Sorry, database creation failed: " . mysqli_error($conn));
}

if (!mysqli_select_db($conn, $dbname)) {
    die("Sorry, could not select db: " . mysqli_error($conn));
}

// insert tables if they do not already exist
$tables = [
    "CREATE TABLE IF NOT EXISTS `users` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `user_id` bigint(20) NOT NULL,
        `user_name` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        `user_type` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `city` varchar(100) NOT NULL,
        `specialty` varchar(100) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `date` (`date`),
        KEY `user_name` (`user_name`)
      );",
    "CREATE TABLE IF NOT EXISTS `appointments` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `creator_id` bigint(20) NOT NULL,
        `recipient_id` bigint(20) NOT NULL,
        `date_time` datetime NOT NULL,
        `message_text` longtext NOT NULL,
        `status` varchar(100) NOT NULL,
        `food_preference` varchar(100) NOT NULL,
        `location` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
      );",
    "CREATE TABLE IF NOT EXISTS `messages` (
        `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
        `recipient_id` bigint(20) NOT NULL,
        `sender_id` bigint(20) NOT NULL,
        `date_time` datetime NOT NULL,
        `message_text` longtext NOT NULL,
        `read_status` varchar(100) NOT NULL,
        PRIMARY KEY (`message_id`)
      );",
];

foreach ($tables as $table_query) {
    if (!mysqli_query($conn, $table_query)) {
        die("Sorry, could not create table: " . mysqli_error($conn));
    }
}

// only perform these queries on db creation
$sql = "select * from users";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

// only insert dummy users if table empty
if ($count == 0) {
    $password = password_hash("pass", PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_type`, `email`, `city`, `specialty`) VALUES ('123456', 'test_provider', '$password', 'medical provider', 'testprovider@example.com', 'Los Angeles', 'Cardiovascular')";
    if (!mysqli_query($conn, $sql)) {
        die("Sorry, sample user creation failed: " . mysqli_error($conn));
    }

    $sql = "INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_type`, `email`, `city`, `specialty`) VALUES ('654321', 'test_supplier', '$password', 'medical supplier', 'testsupplier@example.com', 'New York City', 'Surgical masks')";
    if (!mysqli_query($conn, $sql)) {
        die("Sorry, sample user creation failed: " . mysqli_error($conn));
    }
}

// close the connection
mysqli_close($conn);
