<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// check if user is logged in
$user_data = check_login($conn);

$recipient_name = "";

if (isset($_GET['recipient'])) {
    $recipient_id = $_GET['recipient'];
    $recipient_name = user_id_to_username($conn, $_GET['recipient']);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['recipient-username'])) {
        $recipient_id = username_to_id($conn, $_POST['recipient-username']);
        $sender_id = $_SESSION['user_id'];

        // update timezone to match local one
        date_default_timezone_set('America/Los_Angeles');
        $date_time = date('Y-m-d H:i:s');
        $message_text = htmlspecialchars($_POST['message-text']);
        $read_status = 'UNREAD';

        $query = "insert into messages (recipient_id, sender_id, date_time, message_text, read_status) values ('$recipient_id', '$sender_id', '$date_time', '$message_text', '$read_status')";

        mysqli_query($conn, $query);

        // sends user to confirmation page, then redirects them back to inbox
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
        echo '<div class="text-center">
            <h1 class="text-center">Message sent!</h1>
            <h3 class="text-center">Returning to your messaging inbox...</h3>
            <a href="messaging.php">Click to redirect if it doesn\'t redirect you automatically</a>
        </div>';

        header("refresh:4; url=messaging.php");
    }

    die();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css?<?= time() ?>">
    <title>New Message</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto">
                <a class="navbar-brand" href="../index.php">MediSystem</a>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./schedule.php">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./messaging.php">Messaging</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./search.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="p-3">New Message</h1>
        <form method="POST" id="message-form" class="form-floating mx-auto rounded">

            <div class="p-3">
                <label for="recipient-username" class="form-label">Recipient Username</label>
                <input type="text" class="form-control" placeholder="Example: user12345" name="recipient-username" id="recipient-username" value="<?= $recipient_name ?>" required>
            </div>

            <div class="p-3">
                <label for="message-text" class="form-label">Message body</label>
                <textarea class="form-control" placeholder="Add a message...." rows="4" name="message-text" id="message-text" required></textarea>
            </div>

            <div class="p-3">
                <button class="btn btn-primary" type="submit" id="message-button">Send message</button>
            </div>

        </form>
    </div>
</body>

</html>