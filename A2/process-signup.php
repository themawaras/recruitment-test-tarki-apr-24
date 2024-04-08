<?php

// VALIDASI USER INPUT
if (empty($_POST["username"])) {
    die("Username tidak boleh kosong");
}

if (strlen($_POST["password"]) < 6) {
    die("Password harus terdiri dari 6 karakter atau lebih");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password harus terdiri dari angka");
}

if ($_POST["password"] !== $_POST["pwd_confirmation"]) {
    die("Password keduanya harus sama");
}

// if (empty($_POST["fullname"])) {
//     die("Nama lengkap tidak boleh kosong");
// }

// if (empty($_POST["graduate_from"])) {
//     die("Nama universitas/sekolah tidak boleh kosong");
// }

// if (empty($_POST["gpa"])) {
//     die("Nilai IPK tidak boleh kosong");
// }

// if ($_POST["gpa"] > 4.00 || $_POST["gpa"] < 0) {
//     die("Nilai IPK tidak valid");
// }

// hashing password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// print_r($_POST);
// print_r($password_hash);

// KONEKSI KE DATABASE
$mysqli = require __DIR__ . "/conn.php";

// sql injection ke database
$sql = "INSERT INTO users (username, password)
        VALUES (?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ss",
                  $_POST["username"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html"); // redirect ke halaman signup-success.html
    exit;
 
    // Error handling
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}