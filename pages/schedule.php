<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// check if user is logged in
$user_data = check_login($conn);

$user_id = $user_data['user_id'];

$appointments = get_appointments($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css?<?= time() ?>">
    <title>Schedule</title>
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
    <h1 class="text-center" style="padding: 25px 0px 25px 0px">Scheduling</h1>
    <div class="container p-3">

        <div class="row">
            <div class="col-md-12 p-3">
                <div class=" card p-3">
                    <h2 class="card-title p-3">Appointments</h2>
                    <div class="card-body">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Request ID</th>
                                    <th scope="col">From</th>
                                    <th scope="col">Requested Timeslot</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Food</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- embedded php to display results of query -->
                                <?php foreach ($appointments as $row) : ?>
                                    <?php if ($row['status'] !== 'DENIED') : ?>
                                        <tr>
                                            <?php
                                            // get the username of whoever requested this meeting
                                            $request_id = $row['id'];
                                            $creator_id = $row['creator_id'];
                                            $recipient_id = $row['recipient_id'];
                                            $creator_name = user_id_to_username($conn, $creator_id);
                                            // create new DateTime obj to format the date string
                                            $date_time = new DateTime($row['date_time']);
                                            $date_time = $date_time->format('m/d/Y h:i A');
                                            $message_text = $row['message_text'];
                                            $food_preference = $row['food_preference'];
                                            $location = $row['location'];
                                            $status = $row['status'];
                                            ?>
                                            <td><?= $request_id ?></td>
                                            <td><?= $creator_name ?></td>
                                            <td><?= $date_time ?></td>
                                            <td><?= $message_text ?></td>
                                            <td><?= $food_preference ?></td>
                                            <td><?= $location ?></td>
                                            <td><?= $status ?></td>
                                            <!-- show accept or deny appointment buttons -->
                                            <?php if ($user_id === $recipient_id && $status === 'PENDING') : ?>
                                                <td>
                                                    <form method="POST" action="./accept_appointment.php">
                                                        <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                                        <button type="submit" class="btn btn-primary">Accept</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="POST" action="./deny_appointment.php">
                                                        <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                            <!-- show cancel appointment button -->
                                            <?php if ($status === 'ACCEPTED') : ?>
                                                <td>
                                                    <form method="POST" action="./cancel_appointment.php">
                                                        <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                                                        <button type="submit" class="btn btn-warning">Cancel</button>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-3">
                <div class="card p-3">
                    <h2 class="card-title p-3">Denied Appointments</h2>
                    <div class="card-body">
                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Request ID</th>
                                    <th scope="col">From</th>
                                    <th scope="col">Requested Timeslot</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- embedded php to display results of query -->
                                <?php foreach ($appointments as $row) : ?>
                                    <?php if ($row['status'] === 'DENIED') : ?>
                                        <tr>
                                            <?php
                                            // get the username of whoever requested this meeting
                                            $request_id = $row['id'];
                                            $creator_id = $row['creator_id'];
                                            $recipient_id = $row['recipient_id'];
                                            $creator_name = user_id_to_username($conn, $creator_id);
                                            // create new DateTime obj to format the date string
                                            $date_time = new DateTime($row['date_time']);
                                            $date_time = $date_time->format('m/d/Y h:i A');
                                            $message_text = $row['message_text'];
                                            $status = $row['status'];
                                            ?>
                                            <td><?= $request_id ?></td>
                                            <td><?= $creator_name ?></td>
                                            <td><?= $date_time ?></td>
                                            <td><?= $message_text ?></td>
                                            <td><?= $status ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>