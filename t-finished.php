<?php
session_start();

include ('php/t-auth.php');
include('connection/dbconfig.php'); // Include your database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch the profile picture of the tutor
$tutorID = $_SESSION['auth_tutor']['tutor_id'];
$query = "SELECT profilePicture FROM tutor WHERE tutorID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tutorID);
$stmt->execute();
$stmt->bind_result($profilePicture);
$stmt->fetch();
$stmt->close();

// Check if profile picture exists and if not, use a default image
$profilePicture = !empty($profilePicture) ? $profilePicture : 'img/default-profile.png';
?>




<!DOCTYPE html>
<html>
<head>
  <title>FEUTOR</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">




</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-green bg-green">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="#">PENDING SESSION DETAILS</a>
      <!-- Toggler Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navigation Items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="t-dashboard.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="appointmentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Appointments
            </a>
            <div class="dropdown-menu" aria-labelledby="appointmentsDropdown">
              <a class="dropdown-item" href="t-approved.php">Accepted</a>
              <a class="dropdown-item" href="t-declined.php">Declined</a>
              <a class="dropdown-item" href="t-finished.php">Finished</a>
           </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Notifications</a>
          </li>
          <li class="nav-item dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Display only Profile Picture with slight left alignment -->
                            <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li class="dropdown-header">
                                <strong><?php echo $tutor_firstname; ?></strong>
                            </li>
                            <li><hr class="dropdown-divider"></li> <!-- Line below the name -->
                            <li><a class="dropdown-item" href="t-profile.php">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="t-logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-3" style="margin-top:2.3% !important; margin-right: 20%;">
        <h1 class="s-header">Finished Sessions</h1>
        <div class="row justify-content-center">
            <?php include('php/t-finishedsession.php'); ?>
        </div>
    </div>

  
  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


 


</body>
</html>


