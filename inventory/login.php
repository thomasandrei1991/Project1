<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>POS Login</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>

        <div class="login-container">
            <h1>📦 POS SYSTEM</h1>
            
            <form action="actions/login_action.php" method="POST">
                <input type="text"
                    name="username"
                    placeholder="Username"
                    required>
                
                <input type="password"
                    name="password"
                    placeholder="Password"
                    required>
                
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
    </body>
</html>