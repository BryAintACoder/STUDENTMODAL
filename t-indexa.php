<?php

include ('php/t-auth.php');
include('connection/dbconfig.php'); // Include your database connection file
include('php/approvalStatus.php');
?>




<!DOCTYPE html>
<html>
<head>
  <title>FEUTOR</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/appstat.css">


</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-green bg-green">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="#">FEUTOR</a>
      <!-- Toggler Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navigation Items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Pending Request</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="appointmentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Appointments
            </a>
            <div class="dropdown-menu" aria-labelledby="appointmentsDropdown">
              <a class="dropdown-item" href="#">Accepted</a>
              <a class="dropdown-item" href="#">Declined</a>
              <a class="dropdown-item" href="#">Finished</a>
           </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Notifications</a>
          </li>
          <li class="nav-item dropdown user-dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $tutor_firstname; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="t-logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

    <!-- Wrapper for centering the container-box -->
  <div class="wrapper">
    <div class="container-box">
      <!-- Top box for the image and message -->
      <div class="top-box">
        <img src="img/appstatA.png" alt="Picture" class="top-box-img">
        <p class="top-box-boldmessage">Thank you for joining <br> FEUTOR!</p>
        <p class="top-box-message">Your account is under review. We are processing your registration, and you can expect to be notified within the next 1-2 days once your account has been activated. Thank you for your patience!</p>
      </div>

      <!-- Bottom box with green background -->
      <div class="bottom-box"></div>
    </div>
  </div>
  




  
  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


  <script src="disableBackButton.js"></script>


</body>
</html>


