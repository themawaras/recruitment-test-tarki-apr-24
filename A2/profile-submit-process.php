<?php

session_start();

if (empty($_POST["fullname"])) {
    die("Nama lengkap tidak boleh kosong");
}

if (empty($_POST["graduate_from"])) {
    die("Nama universitas/sekolah tidak boleh kosong");
}

if (empty($_POST["gpa"])) {
    die("Nilai IPK tidak boleh kosong");
}

if ($_POST["gpa"] > 4.00 || $_POST["gpa"] < 0) {
    die("Nilai IPK tidak valid");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/conn.php";

// sql injection ke database
$sql = "INSERT INTO profiles (user_profile_id, fullname, graduate_from, gpa, portfolio_notes)
        VALUES (?, ?, ?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssds",
                  $_SESSION["user_id"],
                  $_POST["fullname"],
                  $_POST["graduate_from"],
                  $_POST["gpa"],
                  $_POST["portfolio_notes"]);
                  
if ($stmt->execute()) {

    header("Location: index.php"); 
    exit;
}}



?>