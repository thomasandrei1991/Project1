<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - POS System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="dashboard-container">
    <nav class="navbar">
        <h1>📦 POS SYSTEM</h1>
        <div class="navbar-links">
            <span style="color: #666;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
    
    <div class="dashboard-content">
        <div class="welcome-card">
            <h2>Dashboard</h2>
            <p>Welcome to your POS System. Select an option from the menu to get started.</p>
        </div>
    </div>
</div>

</body>
</html>