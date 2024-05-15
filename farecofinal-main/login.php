<?php
session_start(); // Start session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fareco_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $input_username);
    $password = mysqli_real_escape_string($conn, $input_password);

    // Query the database to check if user exists
    $sql = "SELECT user_ID, acc_user, acc_pass FROM accounts WHERE acc_user = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['acc_pass']) {
            // Passwords match, log in successful
            $_SESSION['user_ID'] = $row['user_ID'];
            header("Location: index.php"); // Redirect to welcome page
            exit();
        } else {
            $login_error = '<i class="fas fa-exclamation-circle"></i> Invalid password. Please try again.'; // Add icon for invalid password
        }
    } else {
        $login_error = '<i class="fas fa-exclamation-circle"></i> User not found. Please check your username.'; // Add icon for user not found
    }
}

?>


<!DOCTYPE html>
<head>
    <title>Fareco: Fashion Recommendation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Crimson+Text&display=swap">
    

</head>
<body>


      <!-- THIS IS WHERE THE LOG IN INFORMATION STARTS-->
    
      <div class="landing-page">

      
        <h1 id="farecologin"> F A R E C O </h1>
        <h6 id="desclogin"> "Unlock Your Style Potential with FA-RECO: Where Fashion Innovation Meets Personalized Wardrobe Curation. Effortlessly Transform Your Closet into a Styling Sanctuary, Empowering You to Discover, Create, and Share Unique Looks Tailored Just for You."</h6>

        <img src="images/des1.png" alt="design log in" id="login-design">
        
        <h1 id="farecologin"> F A R E C O </h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="text" name="username" id="user-input" placeholder="Username" required>

        <br>

        <div class="password-container">

            <input type="password" name="password" id="pass-input" placeholder="Password" required>

            <span class="toggle-password" onclick="togglePasswordVisibility()">
                  <i class="far fa-eye" id="eye-icon"></i>
            </span>
        
              
        </div>
        <br>

        <input type="submit" id="btn-login" value="Login">
    </form>
    <?php if (isset($login_error)) echo "<p>$login_error</p>"; ?>



    <a href="signup.php" id="createacc">Create an Account</a>
      </div>

      <script src="script.js"></script>
</body>

</html>

<?php
$conn->close();
?>
