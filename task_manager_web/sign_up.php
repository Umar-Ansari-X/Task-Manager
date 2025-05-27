<?php
session_start();
$conn = new mysqli("localhost", "root", "", "task_manager");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: login.php?error=Username already exists. Please choose another one.");


    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php?error=Account created successfully!");


        } else {
            header("Location: login.php?error=Account Error!");


        }
    }
    $stmt->close();
}
$conn->close();
?>

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