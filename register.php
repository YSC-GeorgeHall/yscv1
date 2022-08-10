<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Template · Bootstrap v5.2</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/dashboard/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style type="text/css">
      .contentfromsidenav{
        margin-left: 15%;

      }
      @media only screen and (max-width:600px) {
    .contentfromsidenav {
    width:100%;

  }
}
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>
<body>
<div class="contentfromsidenav">
            <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" style="margin-left: 1.9%;">
                <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Your Shopping Centre</a>
                <?php if( isset($_SESSION['username']) && !empty($_SESSION['username']) )
                    {
                    ?>
                <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
                <?php }else{ ?>

                <?php } ?>
                <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            </header>
            <div class="container-fluid">
                <div class="row">
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <div class="d-flex justify-content-center">
                                    <h5>What are you shopping for?</h5>
                                </div>
                                <li class="nav-item">
                                    <a class="nav-link " href="index.php">
                                    <span data-feather="home" class="align-text-bottom"></span>
                                    Browsing - View All Stores
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="babyandchildren.php">
                                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                                    Baby & Children
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="booksandstationary.php">
                                    <span data-feather="book-open" class="align-text-bottom"></span>
                                    Books & Stationary
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="foodanddrink.php">
                                    <span data-feather="coffee" class="align-text-bottom"></span>
                                    Food & Drink
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="gifts.php">
                                    <span data-feather="gift" class="align-text-bottom"></span>
                                    Gifts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="healthandbeauty.php">
                                    <span data-feather="heart" class="align-text-bottom"></span>
                                    Health & Beauty
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="homewear.php">
                                    <span data-feather="home" class="align-text-bottom"></span>
                                    Homewear
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="jewellery.php">
                                    <span data-feather="shopping-bag" class="align-text-bottom"></span>
                                    Jewellery
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="menswear.php">
                                    <span data-feather="shopping-bag" class="align-text-bottom"></span>
                                    Menswear
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pets.php">
                                    <span data-feather="shopping-bag" class="align-text-bottom"></span>
                                    Pets
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="technology.php">
                                    <span data-feather="cpu" class="align-text-bottom"></span>
                                    Technology
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="travel.php">
                                    <span data-feather="globe" class="align-text-bottom"></span>
                                    Travel
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="womenswear.php">
                                    <span data-feather="shopping-bag" class="align-text-bottom"></span>
                                    Womenswear
                                    </a>
                                </li>
                            </ul>
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                                <?php if( isset($_SESSION['username']) && !empty($_SESSION['username']) )
                                    {
                                    ?>
                                <span>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                                <?php }else{ ?>
                                <span>Create Profile</span>
                                <?php } ?>
                                <a class="link-secondary" href="#" aria-label="Add a new report">
                                <span data-feather="plus-circle" class="align-text-bottom"></span>
                                </a>
                            </h6>
                            <ul class="nav flex-column mb-2">
                                <?php if( isset($_SESSION['username']) && !empty($_SESSION['username']) )
                                    {
                                    ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="view-profile.php">
                                    <span data-feather="user" class="align-text-bottom"></span>
                                    View Your Profile
                                    </a>
                                </li>
<!--                                 <li class="nav-item">
                                    <a class="nav-link" href="view-fav.php">
                                    <span data-feather="star" class="align-text-bottom"></span>
                                    View Your Favourites
                                    </a>
                                </li> -->
          <li class="nav-item">
            <a class="nav-link"  href="reset-password.php">
              <span data-feather="user" class="align-text-bottom"></span>
              Reset Your Password
            </a>
          </li>
                                <?php }else{ ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="register.php">
                                    <span data-feather="user" class="align-text-bottom"></span>
                                    Register
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>

                        </div>
                    </nav>
                </div>
            </div>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel"  >
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="images/ysc.jpg" class="d-block w-100" alt="..." style="height: 300px;">
                        
                    </div>
                    <div class="carousel-item">
                        <img src="images/dl20off.jpg" class="d-block w-100" alt="..." style="height: 300px;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
                </button>
            </div>
  
<div class="container" style="padding-left: 5%;">


    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div> 
</div>
</div>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
    
</html>