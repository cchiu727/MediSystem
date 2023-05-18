<?php
// Copyright (c) 2023 Daniel C & Collin Chiu, All rights reserved 
// checks if a user is logged in and returns user data if so
function check_login($conn)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "select * from users where user_id = '$id' limit 1";

        // retrieve result
        $result = mysqli_query($conn, $query);

        // check if records returned
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // redirect to login
    header("Location: ./pages/login.php");
    die();
}

function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

// get all users in users table
function get_all_users($conn)
{
    $query = "select * from users";
    $result = mysqli_query($conn, $query);
    return $result;
}


// show all messages belonging to a user
function get_user_messages($conn, $user_id)
{
    $query = "select * from messages where recipient_id = '$user_id' order by date_time desc";

    $result = mysqli_query($conn, $query);

    return $result;
}

// get current user's sent messages
function get_sent_messages($conn, $user_id)
{
    $query = "select * from messages where sender_id = '$user_id' order by date_time desc";

    $result = mysqli_query($conn, $query);

    return $result;
}

// convert user id to a username
function user_id_to_username($conn, $user_id)
{
    $query = "select user_name from users where user_id = '$user_id' limit 1";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['user_name'];
        return $user_name;
    }

    die("Failed to get user_name, does not exist within users table");
}

// get all appointments belonging to a user
function get_appointments($conn, $user_id)
{
    $query = "select * from appointments where recipient_id = '$user_id' or creator_id = '$user_id'";

    $result = mysqli_query($conn, $query);

    return $result;
}

// convert username to numeric id
function username_to_id($conn, $recipient_name)
{
    $query = "select user_id from users where user_name = '$recipient_name' limit 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['user_id'];
    }

    die("Failed to get recipient ID, does not exist within users table");
}
