<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
include("../util/connection.php");
include("../util/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // something was posted to the server
    $user_name = $_POST['username'];
    $password = $_POST['password'];

    // we do not want a number as a username
    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        $query = "select * from users where user_name = '$user_name' limit 1";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if (password_verify($password, $user_data['password'])) {
                // set session id
                $_SESSION['user_id'] = $user_data['user_id'];

                // redirect to index
                header("Location: ../index.php");
                die();
            }
        }
        echo '<p class="text-center lead">Wrong username or password</p>';
    } else {
        echo '<p class="text-center lead">Please enter some valid information</p>';
    }
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
    <title>Login</title>
</head>

<body>
    <!-- overall container -->
    <div class="container">
        <!-- begin form -->
        <div class="p-3 text-center">Login</div>
        <form method="POST" id="login-form" class="form-floating mx-auto rounded">
            <div class="p-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>

            <div class="p-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <!-- Toggle password show/hide -->
                <input class="form-check-input" id="password-toggle" type="checkbox" onClick="toggleShow()">
                <label for="password-toggle">Show password</label>
                <script>
                    function toggleShow() {
                        // toggle password script
                        let text = document.getElementById("password");
                        if (text.type === "password") {
                            text.type = "text";
                        } else {
                            text.type = "password";
                        }
                    }
                </script>
            </div>

            <div class="p-3">
                <button class="btn btn-primary" type="submit" id="submit-button">Login</button>
            </div>

            <div class="link-primary p-3">
                <a href="signup.php">Click to signup</a>
            </div>
        </form>
        <!-- end form -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>