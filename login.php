<?php 
session_start();
include 'db.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $result = $conn->query("SELECT * FROM users WHERE username='$user'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row["password"])) {
            $_SESSION["login"] = true;
            header("Location: index.php");
            exit;
        } else {
            $message = "😔 Password salah!";
        }
    } else {
        $message = "😕 User tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Perpustakaan Ceria</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: linear-gradient(135deg, #ffe0e9, #fff6f9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
            position: relative;
        }
        h2 {
            color: #ff6f91;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ffd6e0;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
        }
        button {
            background-color: #ff9aa2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            width: 100%;
            transition: 0.3s;
        }
        button:hover {
            background-color: #ff6f91;
        }
        .error {
            color: #d9534f;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .hello-kitty-container {
            margin-bottom: 15px;
            height: 100px;
            position: relative;
        }
        .hello-kitty {
            width: 80px;
            animation: float 2.5s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>
    <form method="post">
        <div class="hello-kitty-container">
            <img src="https://media0.giphy.com/media/ik0ZEJnTxyEle9LdI8/giphy.webp" 
                 alt="Hello Kitty" class="hello-kitty">
        </div>
        <h2>Login Ceria</h2>
        <?php if ($message): ?>
            <div class="error"><?= $message ?></div>
        <?php endif; ?>
        <input type="text" name="username" placeholder="👤 Username" required>
        <input type="password" name="password" placeholder="🔒 Password" required>
        <button type="submit">🚪 Masuk</button>
    </form>
</body>
</html>
