<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// this script accepts a particular appointment 
// request and is tied to the deny button on schedule.php
if (isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "delete from appointments where id='$appointment_id'";

    if (mysqli_query($conn, $query) && mysqli_affected_rows($conn) > 0) {
        header("Location: schedule.php");
        die();
    }

    die("Failed to delete appointment");
} else {
    die("Illegal request!");
}
