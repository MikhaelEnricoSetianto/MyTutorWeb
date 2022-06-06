<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$name = addslashes($_POST['name']);
$email = addslashes($_POST['email']);
$pass_word = $_POST['password'];
$phonenumber = $_POST['phonenumber'];
$address = $_POST['address'];
$sqlinsert = "INSERT INTO `mytutor`(`name`, `email`, `pass_word`, `phonenumber`, 
`address`) VALUES ('$name','$email','$pass_word','$phonenumber','$address')";
if ($conn->query($sqlinsert) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
    $filename = mysqli_insert_id($conn);
    sendJsonResponse($response);
    echo "<script>alert('Registration Success');</script>";
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    echo "<script>alert('Registration Failed');</script>";
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

header('Location: http://127.0.0.1/mytutor/html/index.html?');
?>