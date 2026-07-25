<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
