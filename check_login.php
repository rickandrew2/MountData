<?php
// check_login.php

session_start();

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']); // Check if session 'user_id' exists
}

// Function to get user profile image path
function getUserImagePath() {
    // Ensure the correct path is returned based on the user session
    if (isLoggedIn()) {
        return '/images/profile_images/' . basename($_SESSION['image_path']); // Assuming image_path stores the image filename
    }
    return '/images/default-profile.png'; // Default image path if not logged in
}

// Function to get user's name
function getUserName() {
    if (isLoggedIn()) {
        return htmlspecialchars($_SESSION['username']); // Assuming user_name stores the user's name in the session
    }
    return 'Guest'; // Return a default name if not logged in
}

// Create a variable to store login status
$loginStatus = isLoggedIn();


// Embed user_id in JavaScript if logged in
$user_id = $loginStatus ? $_SESSION['user_id'] : 'null'; // Use 'null' if not logged in
echo "<script>var userId = $user_id;</script>"; // Pass user_id to JavaScript

// Debugging output (Remove this in production)
// echo "Login Status: " . ($loginStatus ? "Logged In" : "Not Logged In") . "<br>";
// echo "User ID: " . ($loginStatus ? $_SESSION['user_id'] : "None") . "<br>";
// echo "Image Path: " . (isset($_SESSION['image_path']) ? $_SESSION['image_path'] : "No image") . "<br>";
// echo "User Name: " . (isset($_SESSION['username']) ? $_SESSION['user_name'] : "No name") . "<br>";

?>

<script>
    // Pass the image path to JavaScript
    var userImagePath = "<?php echo $imagePath; ?>";
</script>