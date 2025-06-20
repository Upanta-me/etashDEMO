<?php
session_start();
// Remove hardcoded credentials

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_panel.php');
    exit;
}

// Database config
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'etash';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed.');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    $stmt = $conn->prepare('SELECT password FROM admins WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($db_pass);
        $stmt->fetch();
        if ($pass === $db_pass) { // For plaintext passwords; use password_verify() if hashed
            $_SESSION['admin_logged_in'] = true;
            $stmt->close();
            $conn->close();
            header('Location: admin_panel.php');
            exit;
        }
    }
    $error = 'Invalid username or password.';
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Etash Deliveries</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="shortcut icon" href="assets/img/etashlogo2.png">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .login-box {
            max-width: 400px;
            width: 100%;
            margin: 60px auto 60px auto;
            background: #fff;
            padding: 48px 36px 36px 36px;
            border-radius: 22px;
            box-shadow: 0 8px 40px 0 rgba(40,167,69,0.13), 0 2px 16px #0001;
            position: relative;
            z-index: 2;
        }
        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 22px;
        }
        .login-logo img {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(40,167,69,0.13);
            background: #fff;
            object-fit: contain;
        }
        .login-box h2 {
            margin-bottom: 28px;
            text-align: center;
            color: #28a745;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 2rem;
        }
        .login-box input {
            width: 100%;
            padding: 16px 18px;
            margin-bottom: 22px;
            border: 1.5px solid #e0e0e0;
            border-radius: 9px;
            font-size: 1.08rem;
            background: #f4f8fb;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .login-box input:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 0 3px rgba(40,167,69,0.10);
            background: #fff;
        }
        .login-box input:hover {
            background: #f0f7f2;
        }
        .login-box button {
            width: 100%;
            padding: 16px 0;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 1.18rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(40,167,69,0.10);
            transition: background 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .login-box button:hover {
            background: linear-gradient(135deg, #218838, #1abc9c);
            transform: translateY(-2px) scale(1.01);
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 12px 0;
            margin-bottom: 22px;
            text-align: center;
            font-size: 1rem;
        }
        @media (max-width: 500px) {
            .login-box {
                padding: 22px 4vw 18px 4vw;
            }
            .login-logo img {
                width: 52px;
                height: 52px;
            }
            .login-box h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-logo">
            <img src="assets/img/etashlogo2.png" alt="Etash Deliveries Logo">
        </div>
        <h2>Admin Login</h2>
        <?php if ($error) echo '<div class="error">' . $error . '</div>'; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
    </div>
</body>
</html> 