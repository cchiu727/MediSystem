<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

// check if user is logged in
$user_data = check_login($conn);

$user_id = $user_data['user_id'];

$result = get_all_users($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css?<?= time() ?>">
    <title>Search</title>
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
    <div class="container p-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-title">Filter users</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" onkeyup="filterTable()">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Email" onkeyup="filterTable()">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="role" class="form-control" placeholder="Role" onkeyup="filterTable()">
                        </div>


                        <div class="mb-3">
                            <input type="text" name="city" class="form-control" placeholder="City" onkeyup="filterTable()">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="specialty" class="form-control" placeholder="Specialty" onkeyup="filterTable()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <table class="table table-borderless table-striped" id="results-table">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Specialty</th>
                                    <th scope="col">Request Appointment</th>
                                    <th scope="col">Message User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- embedded php to display results of query -->
                                <?php foreach ($result as $row) : ?>
                                    <?php if ($row['user_id'] !== $user_id) : ?>
                                        <tr>
                                            <?php
                                            $current_user_id = $row['user_id'];
                                            $user_name = $row['user_name'];
                                            $email = $row['email'];
                                            $role = $row['user_type'];
                                            $city = $row['city'];
                                            $specialty = $row['specialty'];
                                            ?>
                                            <td><?= $user_name ?></td>
                                            <td><?= $email ?></td>
                                            <td><?= $role ?></td>
                                            <td><?= $city ?></td>
                                            <td><?= $specialty ?></td>
                                            <td>
                                                <a href="./new_appointment.php?recipient=<?= urlencode($current_user_id) ?>">Request appointment</a>
                                            </td>
                                            <td>
                                                <a href="./new_message.php?recipient=<?= urlencode($current_user_id) ?>">Message me<a>
                                            </td>
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
        <script>
            function filterTable() {
                const query = q => document.querySelectorAll(q);
                const filters = [...query('input.form-control')].map(e => new RegExp(e.value, 'i'));

                query('tbody tr').forEach(
                    row => row.style.display = filters.every((f, i) => f.test(row.cells[i].textContent)) ? '' : 'none');
            }
        </script>
</body>

</html>