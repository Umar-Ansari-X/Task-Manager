<?php
session_start();
$conn = new mysqli("localhost", "root", "", "task_manager");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.html");
            exit();
        } else {
            header("Location: login.php?error=Invalid credentials");
            exit();
        }
    } else {
        header("Location: login.php?error=Invalid credentials");
        exit();
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .error-message.visible {
            opacity: 1; 
        }
    </style>
</head>
<body>
    <h1 class="main-title">Task Manager</h1>
    <div class="login-container">
        <form action="login.php" method="POST">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="signup-message">
            <p>Don't have an account? <a href="sign_up.html">Sign up here</a>.</p>
        </div>
        <p class="error-message">
            <?php
            if (isset($_GET['error'])) {
                echo htmlspecialchars($_GET['error']);
            }
            ?>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = document.querySelector('.error-message');
            if (errorMessage.textContent.trim() !== '') {
                errorMessage.classList.add('visible');
            }
        });
    </script>
</body>
</html>