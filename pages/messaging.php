<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// check if user is logged in
$user_data = check_login($conn);

$user_id = $user_data['user_id'];

$received_messages = get_user_messages($conn, $user_id);
$sent_messages = get_sent_messages($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Messaging</title>
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
    <h1 class="text-center" style="padding: 25px 0px 25px 0px">Messaging</h1>
    <div class="container p-3">
        <div class="row">
            <div class="col-md-12 p-3">
                <div class="card p-3">
                    <h2 class="card-title p-3">Inbox</h2>
                    <div class="p-3">
                        <a href="./new_message.php" class="btn btn-primary ">New Message</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">From</th>
                                    <th scope="col">Date and Time</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($received_messages as $row) : ?>
                                    <tr>
                                        <!-- show each sender's name -->
                                        <?php
                                        $message_id = $row['message_id'];
                                        $sender_id = $row['sender_id'];
                                        $recipient_id = $row['recipient_id'];
                                        $sender_username = user_id_to_username($conn, $sender_id);
                                        // create new DateTime obj to format the date string
                                        $date_time = new DateTime($row['date_time']);
                                        $date_time = $date_time->format('m/d/Y h:i A');
                                        $message_text = $row['message_text'];
                                        $read_status = $row['read_status'];
                                        ?>
                                        <td><?= $sender_username ?></td>
                                        <td><?= $date_time ?></td>
                                        <td><?= $message_text ?></td>
                                        <td><?= $read_status ?></td>
                                        <td>
                                            <!-- sender id is the current person we want to message -->
                                            <a href="./new_message.php?recipient=<?= urlencode($sender_id) ?>">Reply</a>
                                        </td>
                                        <?php if ($user_id === $recipient_id && $read_status !== 'READ') : ?>
                                            <td>
                                                <form method="POST" action="./mark_read.php">
                                                    <input type="hidden" name="message_id" value="<?= $message_id ?>">
                                                    <button type="submit" class="btn btn-primary">Mark as read</button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-3">
                <div class="card p-3">
                    <h2 class="card-title p-3">Sent messages</h2>
                    <div class="p-3">
                        <a href="./new_message.php" class="btn btn-primary ">New Message</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">To</th>
                                    <th scope="col">Date and Time</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sent_messages as $row) : ?>
                                    <tr>
                                        <!-- show each sender's name -->
                                        <?php
                                        $recipient_id = $row['recipient_id'];
                                        $recipient_username = user_id_to_username($conn, $recipient_id);
                                        // create new DateTime obj to format the date string
                                        $date_time = new DateTime($row['date_time']);
                                        $date_time = $date_time->format('m/d/Y h:i A');
                                        $message_text = $row['message_text'];
                                        $read_status = $row['read_status'];
                                        ?>
                                        <td><?= $recipient_username ?></td>
                                        <td><?= $date_time ?></td>
                                        <td><?= $message_text ?></td>
                                        <td><?= $read_status ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>