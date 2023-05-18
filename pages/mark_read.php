<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// this script updates the read status of a message by issuing an update by id
if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    $query = "update messages set read_status='READ' where message_id='$message_id'";

    if (mysqli_query($conn, $query) && mysqli_affected_rows($conn) > 0) {
        header("Location: messaging.php");
        die();
    }

    die("Failed to update message read status");
}
