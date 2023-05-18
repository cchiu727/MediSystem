<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// this script denies a particular appointment, and moves it to the denied appointments table
// request and is tied to the deny button on schedule.php
if (isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $query = "update appointments set status='DENIED' where id='$request_id'";

    if (mysqli_query($conn, $query) && mysqli_affected_rows($conn) > 0) {
        header("Location: schedule.php");
        die();
    }

    die("Failed to update appointments");
} else {
    die("Illegal request!");
}
