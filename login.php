<?php
session_start();

// If already logged in, redirect to index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Static admin login
    if ($username === "admin" && $password === "admin") {

        $_SESSION['username'] = "ADMIN";
        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login | Assessment System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="login-body">

    <div class="login-container">
        <div class="login-logo" style="text-align: center;">
            <h1 style="text-align: center; margin: 0 auto; display: block;">Assessment System</h1>
        </div>

        <div class="form-card">
            <h2 style="text-align: center; margin-bottom: 2rem;">Login</h2>

            <?php if ($error != ""): ?>
                <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password"
                        required>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
                </div>
            </form>

            <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">
                <p>Default: admin / admin</p>
            </div>
        </div>
    </div>

</body>

</html>