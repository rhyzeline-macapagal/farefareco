// upload.php
<?php

if (isset($_POST['submit']) && isset($_FILES['image'])) {
    include "connection.php"; // Make sure this path is correct

    // Additional data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = implode(',', $_POST['tags']); // Assuming checkbox values are stored as a comma-separated string

    // Check if a user is authenticated, you need to implement user authentication here
    $acc_user = "user"; // Replace this with actual authenticated user

    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];

    if ($error === 0) {
        if ($img_size > 5000000) { // File size validation
            $em = "Sorry, your file is too large.";
            header("Location: index.php?error=$em");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png"); // Allowed file extensions

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO post (title, content, tags, image, acc_user) 
                        VALUES ('$title', '$content', '$tags', '$new_img_name', '$acc_user')";
                if (mysqli_query($con, $sql)) {
                    header("Location: index.php");
                } else {
                    $em = "Error: " . mysqli_error($con);
                    header("Location: index.php?error=$em");
                }
            } else {
                $em = "You can't upload files of this type";
                header("Location: index.php?error=$em");
            }
        }
    } else {
        $em = "Unknown error occurred!";
        header("Location: index.php?error=$em");
    }
} else {
    header("Location: index.php");
}
?>
