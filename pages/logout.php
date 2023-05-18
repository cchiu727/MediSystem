<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved
session_start();
if (isset($_SESSION['user_id'])) {
    // this logs out the user
    unset($_SESSION['user_id']);
}

header("Location: login.php");
die();
