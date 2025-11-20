<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Supplier Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>SMS Admin</h1>
                <p>Supplier Management System</p>
            </div>

            <form id="login-form" class="login-form">
                <div id="alert-message" class="alert" style="display:none;"></div>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Enter username" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon password-input">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                        <i class="fa-solid fa-eye-slash toggle-password" id="toggle-password"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-sign-in-alt"></i> Sign In
                </button>
            </form>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>
