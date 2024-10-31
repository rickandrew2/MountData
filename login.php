<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script><!-- Include the reCAPTCHA script -->
   
    <!--Icons and Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

     <!-- Favicon -->
     <link rel="icon" href="images/logomount.png" type="image/png" />

</head>
<body>

<!-- NAVIGATION BAR -->
<?php
include 'check_login.php'; // This will check if the user is logged in
include 'db_connection.php'; // Ensure this file contains your database connection code
?>

<nav class="navbar navbar-expand-lg navbar-container fs-5">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="index.php">
                <img src="/images/logomount-removebg-preview.png" alt="Logo" width="100" height="50" class="d-inline-block align-text-top" />
            </a>
        </div>
        <div class="search-container d-flex">
            <span id="search-icon" class="material-symbols-outlined">search</span>
            <input type="text" placeholder="Search" class="search-bar" />
        </div>

         <div class="search-results mt-2"></div> <!-- This will hold the search results -->

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                
            <!-- First Dropdown Link -->
            <li class="nav-item dropdown hideOnMobile">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Explore
                  </a>
                  <!-- Dropdown for Explore -->
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                      <li>
                          <a class="dropdown-item" href="systemfeatures/maps/maps.php"> <!-- Link to specific page -->
                              <span class="dd-icon material-symbols-outlined">nearby</span>
                              <span class="dd-text">Maps</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item" href="community.html"> <!-- Link to specific page -->
                              <span class="dd-icon material-symbols-outlined">groups</span>
                              <span class="dd-text">Community</span>
                          </a>
                      </li>
                  </ul>
              </li>

                 <!-- Second Dropdown Link -->
              <li class="nav-item dropdown hideOnMobile">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Saved
                  </a>
                  <!-- Dropdown for Saved -->
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                      <li>
                          <a class="dropdown-item" href="bookmarks.html"> <!-- Link to specific page -->
                              <span class="dd-icon material-symbols-outlined">bookmarks</span>
                              <span class="dd-text">Bookmarks</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item" href="favorites.html"> <!-- Link to specific page -->
                              <span class="dd-icon material-symbols-outlined">favorite</span>
                              <span class="dd-text">Favorites</span>
                          </a>
                      </li>
                  </ul>
              </li>


                <li class="nav-item nav-login hideOnMobile mx-5">
                    <?php if ($loginStatus): ?>
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo htmlspecialchars(getUserImagePath()); ?>" alt="Profile Picture" width="40" height="40" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="profile.php">Settings</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <a class="nav-link" href="login.php">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!--LOGIN CONTAINER-->

<div class="bg-image" style="background-image: url('/images/login-bg.jpg'); background-size: cover; background-position: center;">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 d-flex justify-content-center">
                <div class="form-container mt-5 mb-5 p-4 d-flex align-items-center flex-column">
                    <div class="row w-100">
                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                            <img src="/images/logomount-removebg-preview.png" alt="Logo" class="img-fluid login-img">
                        </div>
                        <div class="col-md-7">
                            <h2 class="mb-4 text-center">Login</h2>

                            <?php if (isset($_SESSION['login_success'])): ?>
                                <div class="alert alert-success">
                                    <?php
                                    echo $_SESSION['login_success'];
                                    unset($_SESSION['login_success']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['login_error'])): ?>
                                <div class="alert alert-danger">
                                    <?php
                                    echo $_SESSION['login_error'];
                                    unset($_SESSION['login_error']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form action="login_handler.php" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control custom-input" placeholder="Email or Username" required>
                                </div>

                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control custom-input" placeholder="Password" required>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePasswordVisibility()">👁</button>
                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content-center">
                                    <div class="g-recaptcha" data-sitekey="6LdUD18qAAAAAIYxJqGUgDDQuy_rT4LPp8o4-CNt"></div> <!-- Replace with your site key -->
                                </div>

                                <button type="submit" name="login" class="btn custom-green w-100">Login</button>
                            </form>

                            <div class="text-center mt-3">
                                <p><a href="forgot_password.php">Forgot Password?</a></p>
                            </div>

                            <div class="text-center mt-3">
                                <p>Don't have an account? <a href="/register.php">Register here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--FOOTER-->
<footer>
    <div class="container-fluid footer1">
      <div class="row p-5 text-center text-md-start">
        <div class="col-12 col-md-4 mb-4">
          <span class="ftr-icon material-symbols-outlined">photo_camera</span>
          <h3 class="mt-3 fs-2 footer-title">Share Your Journey</h3>
          <h3 class="mt-3 fs-4 footer1-des" style="text-align: justify;">Connect with fellow adventurers and share your experiences. Tag us in your photos to inspire others!</h3>
        </div>
        <div class="col-12 col-md-4 mb-4">
          <span class="ftr-icon material-symbols-outlined">landscape</span>
          <h3 class="mt-3 fs-2 footer-title">Adventure Awaits</h3>
          <h3 class="mt-3 fs-4 footer1-des" style="text-align: justify;">Every adventure brings a new experience. Discover breathtaking trails, hidden gems, and the beauty of nature with us.</h3>
        </div>
        <div class="col-12 col-md-4 mb-4">
          <span class="ftr-icon material-symbols-outlined">explore</span>
          <h3 class="mt-3 fs-2 footer-title">Explore Responsibly</h3>
          <h3 class="mt-3 fs-4 footer1-des" style="text-align: justify;"> We believe in responsible exploration. Follow our guidelines to leave minimal impact and preserve the beauty of nature.</h3>
        </div>
      </div>
    </div>
</footer>

    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
    <script src="systemfeatures/search/search.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>
