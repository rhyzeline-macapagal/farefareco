<?php
include "connection.php"; // Ensure this path is correct

// Check if a tag parameter is provided in the URL
if(isset($_GET['tag'])) {
    $selectedTag = $_GET['tag'];
    $sql = "SELECT title, content, likes, tags, acc_user, image FROM post WHERE tags LIKE '%$selectedTag%'";
} else {
    // If no tag parameter is provided, fetch all posts
    $sql = "SELECT title, content, likes, tags, acc_user, image FROM post";
}

$result = mysqli_query($con, $sql);

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
</head>
<body>
    <header> 
        <h3 id="headtitle"> F A R E C O </h3>
        <div class="search-container">
            <input type="text" id="search-bar" placeholder="Search...">
            <!-- Notification icon -->
            <i class="fas fa-bell notification-icon"></i>
            <!-- Profile circle -->
            <a href="userpage.php">
                <div id="profile-circle"></div>
            </a>
            <span id="profile-label">Username</span>
        </div>
    </header>

    <div class="circle-button">
        <img src="images/1.png" alt="shirt" onclick="filterPosts('shirt')" title="shirt" id="shirt">
        <img src="images/0.png" alt="all" onclick="filterPosts('all')" title="all" id="all">
        <img src="images/2.png" alt="short" onclick="filterPosts('short')" title="short" id="short">
        <img src="images/3.png" alt="pants" onclick="filterPosts('pants')" title="pants" id="pants">
        <img src="images/4.png" alt="skirt" onclick="filterPosts('skirt')" title="skirt" id="skirt">
        <img src="images/5.png" alt="dress" onclick="filterPosts('dress')" title="dress" id="dress">
    </div>

    <div class="menus">
        <img src="images/plus.png" alt="plus" title="add post" id="plus" onclick="togglePostingPanel()">
        <img src="images/match.png" alt="match" title="matchmake clothes" id="match" onclick="toggleMatchPanel()">
    </div>

    <!-- Pop-up panel for posting -->
    <div class="popup-post" id="postingPanel">
        <div class="popup-content">
            <header>
                <h1>Create a New Post</h1>
            </header>
            <main>
                <form id="postForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required><br><br>

                    <label for="content">Content:</label><br>
                    <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/*"><br><br>

                    <!-- Image container -->
                    <div id="imageContainer"></div><br>

                    <!-- Tags -->
                    <label>Tags:</label><br>
                    <input type="checkbox" id="tag-shirt" name="tags[]" value="shirt" onclick="uncheckOtherTags('tag-shirt')">
                    <label for="tag-shirt">Shirt</label><br>
                    <input type="checkbox" id="tag-skirt" name="tags[]" value="skirt" onclick="uncheckOtherTags('tag-skirt')">
                    <label for="tag-skirt">Skirt</label><br>
                    <input type="checkbox" id="tag-pants" name="tags[]" value="pants" onclick="uncheckOtherTags('tag-pants')">
                    <label for="tag-pants">Pants</label><br>
                    <input type="checkbox" id="tag-short" name="tags[]" value="short" onclick="uncheckOtherTags('tag-short')">
                    <label for="tag-short">Short</label><br>
                    <input type="checkbox" id="tag-dress" name="tags[]" value="dress" onclick="uncheckOtherTags('tag-dress')">
                    <label for="tag-dress">Dress</label><br><br>

                    <button type="submit" name="submit">Post</button>
                </form>
            </main>
        </div>
    </div>

    <!-- Pop-up panel for matching -->
    <div class="popup-match" id="matchPanel">
        <div class="popup-content">
            <header>
                <h1>Match Clothes</h1>
            </header>
            <main>
                <!-- Add content for matching clothes here -->
            </main>
        </div>
    </div>

    <section id="newsfeed" class="scrollable">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='post'>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p>" . htmlspecialchars($row['content']) . "</p>";
            if (!empty($row['image'])) {
                echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . "' style='max-width: 100%; height: auto;'>";
            }
            echo "<p><strong>Likes:</strong> " . htmlspecialchars($row['likes']) . "</p>";
            echo "<p><strong>Tags:</strong> " . htmlspecialchars($row['tags']) . "</p>";
            echo "<p><strong>Posted by:</strong> " . htmlspecialchars($row['acc_user']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts yet.</p>";
    }

    mysqli_close($con);
    ?>
</section>


<script>
    function togglePostingPanel() {
        var panel = document.getElementById("postingPanel");
        panel.classList.toggle("active");
    }

    function toggleMatchPanel() {
        var panel = document.getElementById("matchPanel");
        panel.classList.toggle("active");
    }

    function filterPosts(tag) {
    // If tag is "all", redirect to the same page without any tag parameter
    if (tag === 'all') {
        window.location.href = 'index.php';
    } else {
        // Redirect to the same page with the selected tag as a query parameter
        window.location.href = 'index.php?tag=' + tag;
    }
    
    // Remove the clicked class from all buttons
    var buttons = document.querySelectorAll('.circle-button img');
    buttons.forEach(function(button) {
        button.classList.remove('clicked');
    });
    
    // Add the clicked class to the clicked button
    var clickedButton = document.getElementById(tag);
    clickedButton.classList.add('clicked');
}


    function uncheckOtherTags(clickedTagId) {
        // Get all checkboxes with the name "tags[]"
        var checkboxes = document.getElementsByName('tags[]');
        
        // Loop through all checkboxes
        checkboxes.forEach(function(checkbox) {
            // Uncheck the checkbox if it is not the one that was clicked
            if (checkbox.id !== clickedTagId) {
                checkbox.checked = false;
            }
        });
    }
</script>
</body>
</html>
