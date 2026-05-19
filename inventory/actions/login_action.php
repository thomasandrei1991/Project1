<?php

    session_start();

    require_once "../config/database.php";

    /** @var mysqli $conn */

    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users
                WHERE username='$username'
                AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){

            $_SESSION['username'] = $username;

            header("Location: ../dashboard.php");

        }else{

            echo "Invalid Username or Password";

        }

    }

?>