<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/conn.php";
    
    $sql = sprintf("SELECT * FROM users
                    WHERE username = '%s'",
                   $mysqli->real_escape_string($_POST["username"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"]) && empty($user["deleted_at"])) {
            
            session_start();
            
            // session_regenerate_id();
            
            $_SESSION["user_id"] = $user["user_id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            text-align: left;
        }

        form {
            width: 300px;
            height: auto;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        input[type="textarea"] {
            width: 100%;
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

        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>
    <h2>Halaman Log In Akun</h2>

    <?php if ($is_invalid): ?>
        <p style="text-align:center; color:red"><em>Username/password salah</em></p>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="masukkan username anda" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="masukkan password anda">
        </div>
        <div>
            <button type="submit" name="login">Log In</button>
        </div>
    </form>
</body>

</html>