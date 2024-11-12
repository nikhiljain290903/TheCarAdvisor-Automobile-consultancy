<?php
$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];
$message = $_POST['message'];

if (!empty($name) || !empty($email) || !empty($number) || !empty($message)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "thecaradvisor";

    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    $SELECT = "SELECT email From queries Where email = ? Limit 1";
    $INSERT = "INSERT Into queries (name, email, number, message) values(?, ?, ?, ?)";

    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum == 0) {
        $stmt->close();

        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssis", $name, $email, $number, $message);
        $stmt->execute();
        echo "<script type='text/javascript'> alert('Successfully Registerd!!!')</script>";
        require("home.html");
    } else {
        echo "<script type='text/javascript'> alert('Email is already existed in our database.')</script>";
    }
    // $stmt -> close();
    // $conn -> close();

} else {
    echo "All fields are required.";
    die();
}
