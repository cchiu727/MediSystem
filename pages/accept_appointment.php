<?php
session_start();
include("../util/connection.php");
include("../util/functions.php");

// this script accepts a particular appointment 
// request and is tied to the deny button on schedule.php
if (isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $query = "update appointments set status='ACCEPTED' where id='$request_id'";

    if (mysqli_query($conn, $query) && mysqli_affected_rows($conn) > 0) {
        header("Location: schedule.php");
        die();
    }

    die("Failed to update appointments");
} else {
    die("Illegal request!");
}
