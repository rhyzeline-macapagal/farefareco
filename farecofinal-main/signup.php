<?php 
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['signuser'];
    $password = $_POST['signpass'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        //save to database
        $user_ID = random_num(5);
        $query = "INSERT INTO accounts (user_ID, Fname, Lname, acc_user, acc_pass) VALUES ('$user_ID', '$fname', '$lname', '$user_name', '$password')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('User added successfully!');</script>";
            header("Location: login.php");
            die;
        } else {
            echo "<script>alert('Failed to add user!');</script>";
        }
    } else {
        echo "<script>alert('Please enter valid information!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fareco: Fashion Recommendation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Crimson+Text&display=swap">
    <script src="https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.11.1/firebase-auth.js"></script>
</head>
<body>

<div class="landing-page">
    <h1 id="farecologin"> F A R E C O </h1>
    <h6 id="descsign"> "Unlock Your Style Potential with FA-RECO: Effortlessly Transform Your Closet into a Styling Sanctuary, Empowering You to Discover, Create, and Share Unique Looks Tailored Just for You."</h6>

    <img src="images/des1.png" alt="design sign up" id="sign-design">
    <h1 id="farecologin"> F A R E C O </h1>
<form method="post">
    <div class="sign-page" id="signup-form">
    <input type="text" name="firstname" id="firstname" placeholder="First name" required>
    <input type="text" name="lastname" id="lastname" placeholder="Last name" required>
    <input type="text" name="signuser" id="signuser" placeholder="Username" required>
    <br>
    <input type="password" name="signpass" id="signpass" placeholder="Password" required>
    <span class="toggle-password" onclick="togglePasswordVisibility()">
        <i class="far fa-eye" id="eye-icon"></i>
    </span>
    <br>
    <input type="password" name="signrepass" id="signrepass" placeholder="Re-enter Password" required>
    <br>
    <button id="btn-sign">Sign Up</button>
</form>
</div>

</div>


</body>
</html>
