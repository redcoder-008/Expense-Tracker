<?php
session_start();
include 'includes/config.php';

// Handle Login
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: home.php');
        exit;
    } else {
        $login_error = "Invalid email or password!";
    }
}

// Handle Signup
if (isset($_POST['signup'])) {
    $username = $_POST['signup_name'];
    $email = $_POST['signup_email'];
    $password = password_hash($_POST['signup_password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        header('Location: login.php?signup=success');
        exit;
    } catch (PDOException $e) {
        $signup_error = "Email already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/login.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Expense Tracker - Login</title>
</head>
<body>
    <div class="container" id="container">
        <!-- Sign Up Form -->
        <div class="form-container sign-up">
            <form method="POST">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>or use your email for registration</span>
                <?php if (isset($signup_error)): ?>
                    <div class="error-message"><?= $signup_error ?></div>
                <?php endif; ?>
                <input type="text" name="signup_name" placeholder="Name" required>
                <input type="email" name="signup_email" placeholder="Email" required>
                <input type="password" name="signup_password" placeholder="Password" required>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>

        <!-- Sign In Form -->
        <div class="form-container sign-in">
            <form method="POST">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>or use your email password</span>
                <?php if (isset($login_error)): ?>
                    <div class="error-message"><?= $login_error ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
                    <div class="success-message">Registration successful! Please login.</div>
                <?php endif; ?>
                <input type="email" name="login_email" placeholder="Email" required>
                <input type="password" name="login_password" placeholder="Password" required>
                <a href="#">Forgot Your Password?</a>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>

        <!-- Toggle Container -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>New Here?</h1>
                    <p>Register with your personal details to get started</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/login.js"></script>
</body>
</html>