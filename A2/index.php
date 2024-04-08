<?php

session_start();

$is_update = false;
// print_r($_SESSION);
$mysqli = require __DIR__ . "/conn.php";

if (!empty($_SESSION["user_id"])) {
    $sql = sprintf("SELECT * FROM profiles
                WHERE user_profile_id = '%s'",
               $mysqli->real_escape_string($_SESSION["user_id"]));
               
               $result = $mysqli->query($sql);
               $profile = $result->fetch_assoc();

               if (empty($profile)) {

                header("Location: profile-submit.html");
                exit;
                // echo 'empty';
               }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // $mysqli = require __DIR__ . "/conn.php";

// sql injection ke database
$sql = "UPDATE profiles
        SET fullname = '?',
            graduate_from = '?',
            gpa = ?,
            portfolio_notes = '?',
            updated_at = now()
        WHERE user_profile_id = ?;";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssdss",
                  $_POST["fullname"],
                  $_POST["graduate_from"],
                  $_POST["gpa"],
                  $_POST["portfolio_notes"],
                  $_SESSION["user_id"]);
                  
if ($stmt->execute()) {

    header("Location: index.php"); 
    exit;
}
$is_update = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        h2 {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin-top: 50px;
            padding: 0;
            text-align: center;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        form {
            width: 500px;
            height: auto;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        input[type="text"],
        input[type="password"],
        button[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="number"] {
            width: 30%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;

        }

        textarea {
            width: 100%;
            height: 400px;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            height: auto;
            overflow: hidden;
            resize: none;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .login-button {
            margin: 10px auto;
            width: 25%;
            background-color: dodgerblue;
            border-radius:10px;
            color: #fff;
            padding: 1px 0;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #007bff;
        }

        .signup-button {
            margin: 10px auto;
            width: 25%;
            background-color: mediumseagreen;
            border-radius:10px;
            color: #fff;
            padding: 1px 0;
            cursor: pointer;
        }

        .signup-button:hover {
            background-color: mediumaquamarine;
        }

        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Selamat Datang</h1>

    <?php if (isset($profile)): ?>

        <p>Selamat datang <?= htmlspecialchars($profile["fullname"]) ?> di halaman profile anda</p>
        <p>Jika anda hendak keluar dari akun anda, silakan klik <a href="logout.php">log out</a>.</p>

        <?php if ($is_update): ?>
        <p style="text-align:center; color:green"><em>Data profile berhasil diubah</em></p>
    <?php endif; ?>

        <form method="post">
        <div>
            <label for="fullname">Nama lengkap</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $profile["fullname"]; ?>">
        </div>
        <div>
            <label for="graduate_from">Lulusan dari</label>
            <input type="text" id="graduate_from" name="graduate_from" value="<?php echo $profile["graduate_from"]; ?>">
        </div>
        <div>
            <label for="gpa">IPK</label><br>
            <input type="number" id="gpa" name="gpa" value="<?php echo $profile["gpa"]; ?>">
        </div>
        <div>
            <label for="portfolio_notes">Catatan Portfolio</label>
            <textarea type="textarea" id="portfolio_notes" name="portfolio_notes"><?php echo $profile["portfolio_notes"]; ?></textarea>
        </div>
        <div>
            <button type="submit" name="submit">Update</button>
        </div>
        </form>

    <?php else: ?>

        <p>Ini merupakan halaman bagi pelamar kerja, silakan lakukan</p>
        <p>Log In jika telah memiliki akun, atau daftar akun melalui Sign Up</p>
        <div onclick="location.href='login.php';" class="login-button">
            <p>Log In</p>
        </div>
        <div>
            <p style="color:dimgray; font-size:small;">atau</p>
        </div>
        <div onclick="location.href='signup.html';" class="signup-button">
            <p>Sign Up</p>
        </div>

    <?php endif; ?>
    
</body>
</html>