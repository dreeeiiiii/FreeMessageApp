<?php include("../includes/process.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Form</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
    <div class="login-form-container">
        <h2>ADMIN LOGIN DASHBOARD</h2>

        <!-- Display error message -->
        <?php if (!empty($errormessage)): ?>
            <p class="error"><?php echo $errormessage; ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="" method="post">
            <div class="email-field">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
            </div>

            <div class="password-field">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
