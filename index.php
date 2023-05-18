<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved

session_start();
include_once("./util/create_db_and_tables.php");
include("./util/connection.php");
include("./util/functions.php");

// check if user is logged in
$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css?<?= time() ?>">
    <title>Home</title>
</head>

<body>
    <!-- create the navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto">
                <a class="navbar-brand" href="./index.php">MediSystem</a>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/schedule.php">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/messaging.php">Messaging</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/search.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- hero of page -->
        <div class="row justify-content-center">
            <h1 class="display-3 fw-bold mb-3 text-center">MediSystem</h1>
            <p class="lead mb-3 text-center">
                We make medical office and supplier communication easier. Join today!
            </p>
        </div>

        <!-- image row -->
        <div class="row justify-content-center p-3">
            <img src="./images/healthcare-stockimage.jpg" class="img-fluid rounded-circle" id="healthcare-img">
        </div>

        <!-- dashboard button row -->
        <div class="row justify-content-center">
            <div class="d-grid justify-content-center">
                <a href="pages/dashboard.php" class="btn btn-dark btn-lg">Visit Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>