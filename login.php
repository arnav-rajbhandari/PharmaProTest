<html>
<head>
    <title>Login</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
     <script src="script.js"></script>
<?php
// Configuration
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to retrieve user data
    $query = "SELECT * FROM users WHERE username =? AND password =?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User exists, start session and redirect to dashboard
        session_start();
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        // User doesn't exist, display error message
        $error = "Invalid username or password";
    }
}

// Close connection
$conn->close();
?>

<!-- Display error message if any -->
<?php if (isset($error)) {?>
    <p style="color: red;"><?php echo $error;?></p>
<?php }?>


    <div class="login-body">
        <div class="login-container">
            <div class = "login-header">
                <img src="logo.png" alt="Pharma Pro Logo" class="logo-img">
            </div>
            <div class="login-form">
                <h3>Welcome to Pharma Pro</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-group">
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>
                    <div class="input-group">
                        <button type="submit" class="login-btn">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>