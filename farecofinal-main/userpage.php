<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fareco: Fashion Recommendation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Crimson+Text&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.11.1/firebase-database.js"></script>
</head>

<body>
    <header> 
        <h3 id="headtitle"> 
            <!-- Back Icon --> 
            <a href="index.php" class="back-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            F A R E C O 
            <i class="fas fa-bars hamburger-icon" onclick="togglePanel()"></i> 
        </h3>
    </header>

    <div class="menus">
        <img src="images/plus.png" alt="plus" title="add post" id="plus">
        <img src="images/match.png" alt="match" title="matchmake clothes" id="match">
        
    </div>

    <!-- Pop-up panel for main actions -->
    <div class="popup-panel" id="popupPanel">
        <div class="popup-content">
            <!-- Content of the pop-up panel -->
            <i class="fas fa-arrow-left back" onclick="togglePanel()"></i>

            <p style="text-align: center;">ABOUT</p>
            <p>You can add any content here.</p>
            <a href="login.php">
             <button> LOGOUT </button>
            </a>
        </div>
    </div>

    <!-- Profile elements -->
    <img src="images/profuser.png" alt="profile picture" title="profile picture" id="profsize" >
    
    <span id="profileuserlbl"><?php echo $user_data['acc_user']; ?></span>
    <img src="images/profplus.png" alt="profile picture" title="profile picture" id="profpic" onclick="toggleAvatarPanel()">
    
    <div class="userinfo">
        <div class="socials">
            <div class="social">
                <span id="numfollow">0</span>
                <span>Followers</span> 
            </div>
            <div class="social">
                <span id="numpost">0</span>
                <span>Posts</span> 
            </div>
            <div class="social">
                <span id="numfollowing">0</span>
                <span>Following</span>
            </div>
        </div>
    </div>

    <!-- Pop-up panel for picking avatar -->
    <div class="popup-avatar" id="avatarPanel">
        <div class="popup-content3">
            <i class="fas fa-arrow-left back" onclick="toggleAvatarPanel()"></i>

            <p style="text-align: center;">PICK AVATAR</p>
            <div class="placeholder-images">
                <img src="images/avatar1.png" alt="Placeholder" class="profile-image" id="image1">
                <img src="images/avatar2.png" alt="Placeholder" class="profile-image" id="image2">
                <img src="images/avatar3.png" alt="Placeholder" class="profile-image" id="image3">
                <img src="images/avatar4.png" alt="Placeholder" class="profile-image" id="image4">
            </div>
            <input type="text" id="name-bar" placeholder="Input username">
            <button id="userbtn">Done</button>
        </div>
    </div>

    <script>
        function togglePanel() {
            var panel = document.getElementById("popupPanel");
            panel.classList.toggle("active");
        }
    
        function showAvatarPanel() {
            var panel = document.getElementById("avatarPanel");
            panel.classList.add("active");

            // Show input field
            var nameBar = document.getElementById('name-bar');
            nameBar.style.display = "block";

            // Add event listener to the "Done" button
            var doneButton = document.getElementById('userbtn');
            doneButton.addEventListener('click', applyAvatarAndName);

            // Add event listener to the placeholder images
            var placeholderImages = document.querySelectorAll('.profile-image');
            placeholderImages.forEach(image => {
                image.addEventListener('click', selectAvatar);
            });
        }

        function selectAvatar(event) {
            // Remove selected-avatar class from all images
            var profileImages = document.querySelectorAll('.profile-image');
            profileImages.forEach(image => {
                image.classList.remove('selected-avatar');
            });

            // Add selected-avatar class to the clicked image
            event.target.classList.add('selected-avatar');
        }

        function applyAvatarAndName() {
            var newName = document.getElementById('name-bar').value;
            var profileNameLabel = document.getElementById('profileuserlbl');
            profileNameLabel.innerText = newName;

            var selectedAvatar = document.querySelector('.profile-image.selected-avatar');
            if (selectedAvatar) {
                var profileuser = document.getElementById('profsize');
                profileuser.src = selectedAvatar.src;
            }

            // Hide the input field after applying the name
            var nameBar = document.getElementById('name-bar');
            nameBar.style.display = "none";

            // Close the avatar panel
            var panel = document.getElementById("avatarPanel");
            panel.classList.remove("active");

            // Add the username to the database
            var userId = document.getElementById('profileuserlbl').innerText; // Assuming the username is also the user ID
            var username = newName; // New username from the input field
            var userRef = firebase.database().ref('users/' + userId);
            userRef.update({
                username: username
            }).then(() => {
                console.log("Username added to database");
            }).catch((error) => {
                console.error("Error adding username to database:", error);
            });
        }

        // Add event listener to the "Change Avatar" button
        var changeAvatarButton = document.getElementById('profpic');
        changeAvatarButton.addEventListener('click', showAvatarPanel);
    </script>
</body>
</html>
