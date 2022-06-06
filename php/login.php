<?php

if (isset($_POST['submit'])) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}    
    include 'dbconnect.php';
    $email = addslashes($_POST['email']);
    $pass_word = $_POST['password'];
    $sqllogin = "SELECT * FROM mytutor WHERE email = '$email' AND pass_word = '$pass_word'";
    $result = mysqli_query($conn, $sqllogin) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            session_start();
            $_SESSION["sessionid"] = session_id();
            $_SESSION["email"] = $email ;
            echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('home.php')</script>";
        } else {
            echo "<script>alert('Login Failed! Please Check Your Email and/or Password!');</script>";
            echo "<script> window.location.replace('../html/index.html')</script>";
        }
?>    
        