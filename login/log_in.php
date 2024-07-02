<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="./check_user.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class = "input-group">
            <a href="./google_log_in.php">Google ile Giriş Yap</a>
        </div>
        <div class="input-group">
                <label >Don't have an account?</label>
                <a href="./sign_in.php">Sign-in</a>
        </div>
    </div>
</body>
</html>
