<?php
echo "<style type='text/css'>

.profile-picture {
  margin: 10px auto; /* Center the profile picture */
  max-width: 200px;
  max-height: 200px;
  width: 160px; /* Set a fixed width */
  height: 160px; /* Set a fixed height */
  object-fit: cover; /* Maintain aspect ratio and cover the container */
}
.tutorName {
  position: absolute; 
  top: 8%; 
  left: 18.5%; 
  margin-left: 0px; 
  margin-right: 0px; 
  font-size: 20px;
}
.degreeProgram {
  position: absolute; 
  top: 25%; 
  left: 17%; 
  margin-left: 0px; 
  margin-right: 0px; 
  font-size: 15px;
  width: 100%;
}
.icongrad {
  width: 33px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */
  position: relative; 
  margin-bottom: 0.5%;
  margin-left: 1%;
}
.mode {
  position: absolute; 
  top: 37%; 
  left: 17.7%; 
  margin-left: 1px; 
  margin-right: 0px; 
  font-size: 15px;
  width: 100%;
}
.iconmode {
  width: 20px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */
  position: relative; 
  margin-bottom: 0.5%;
  margin-right: 0.5%;
  margin-left: 1%;
  object-fit: cover;
}
.subj {
  position: absolute; 
  top: 49%; 
  left: 17.7%; 
  margin-left: 1px; 
  margin-right: 0px; 
  font-size: 15px;
  width: 100%;
  font-weight: 600;
}
.iconsubj {
  width: 19px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */
  position: relative; 
  margin-bottom: 0.5%;
  margin-right: 0.5%;
  margin-left: 1%;
  object-fit: cover;
}
.bio {
  position: absolute;
  top: 65%;
  left: 19%;
  margin-left: 1px;
  margin-right: 0px;
  font-size: 15px;
  width: 58%;
  color: #666; /* Grey font color */
  font-style: italic; /* Italic font */
}
.btn-outline-success {
  color: #0F422A;
  background-color: #ffffff;
  border-color: #0F422A;
  font-weight: bold;
  letter-spacing: 0.05em;
  bottom: 10%;
  left: 79%;
  width: 200px;
  height: 40px;
  position: absolute;
  z-index: 2;
}
.btn-outline-secondary {
  background-color: #ffffff;
  border-color: #0F422A;
  font-weight: bold;
  letter-spacing: 0.05em;
  bottom: 35%;
  left: 79%;
  width: 200px;
  height: 40px;
  position: absolute;
  z-index: 2;
  color: #0F422A;
}
.rate {
  bottom: 59%;
  left: 88%;
  width: 200px;
  height: 40px;
  position: absolute;
  z-index: 2;
  font-size: 23px;
  font-weight: 300px;
}
.modal-content {
max-height: 60vh;
padding: 20px; /* Adjust padding inside the modal */
}

.modal-header, .modal-footer {
    padding: 10px; /* Adjust padding for header and footer */
}
</style>";

// SQL query to fetch data from the tutor table where approvalStatus is 'Approved'
$sql = "SELECT tutorID, firstName, lastName, degreeProgram, year, profilePicture, subjectExpertise, teachingMode, ratePerHour, bio 
FROM tutor 
WHERE approvalStatus = 'Approved' AND subjectExpertise IS NOT NULL AND teachingMode IS NOT NULL AND ratePerHour IS NOT NULL AND bio IS NOT NULL";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Loop through the result set and display the data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='col-md-12 mb-3' style='margin-left: 10px; width: 100% !important;'>";
        echo "<div class='card shadow custom-card' style='height: 200px; margin-top: 1%;'>";
        echo "<div class='card-body'>";

        // Display tutor information
        echo "<h4 class='tutorName'>" . htmlspecialchars($row['firstName'] . " " . $row['lastName']) . "</h4>";
        echo "<p class='degreeProgram'>" . "<img src='icons/grad.png' class='icongrad'/>" . htmlspecialchars($row['degreeProgram']) . " - " . htmlspecialchars($row['year']) . "</p>";
        echo "<p class='card-text'><img src='" . htmlspecialchars($row['profilePicture']) . "' alt='Profile Picture' class='profile-picture'></p>";
        echo "<p class='mode'>" . "<img src='icons/mode.png' class='iconmode'/>"  . htmlspecialchars($row['teachingMode']) . "</p>";
        echo "<p class='subj'>" . "<img src='icons/subj.png' class='iconsubj'/>"  . htmlspecialchars($row['subjectExpertise']) . "</p>";
        echo "<p class='bio'>" . htmlspecialchars(substr($row['bio'], 0, 155)) . (strlen($row['bio']) > 75 ? '...' : '') . "</p>";
        echo "<p class='rate'> ₱" . htmlspecialchars($row['ratePerHour']) . "/hr</p>";


        // Add the "View More Details" button
        echo "<button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#detailsModal{$row['tutorID']}'>View More Details</button>";
// Modal code for tutor details
echo "
<div class='modal fade' id='detailsModal{$row['tutorID']}' tabindex='-1' role='dialog' aria-labelledby='detailsModalLabel{$row['tutorID']}' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered modal-xl' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='detailsModalLabel{$row['tutorID']}'>Details for " . htmlspecialchars($row['firstName'] . " " . $row['lastName']) . "</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class='container'>
                    <div class='profile-picture-container'>
                        <img src='" . htmlspecialchars($row['profilePicture']) . "' alt='Profile Picture' class='profile-picture'>
                    </div>
                    <p class='tutorName' style='margin-left: 20px;'><strong>" . htmlspecialchars($row['firstName'] . " " . $row['lastName']) . "</strong></p>
                    <p class='degreeProgram' style='margin-left: 40px;'>" . htmlspecialchars($row['degreeProgram']) . " - " . htmlspecialchars($row['year']) . "</p>
                    <p class='mode' style='margin-left: 20px;'><img src='icons/mode.png' class='iconmode'/>" . htmlspecialchars($row['teachingMode']) . "</p>
                    <p class='subj' style='margin-left: 20px;'><img src='icons/subj.png' class='iconsubj'/>" . htmlspecialchars($row['subjectExpertise']) . "</p>
                    <p class='rate' style='margin-left: 20px;'>₱" . htmlspecialchars($row['ratePerHour']) . "/hr</p>
                </div>
                <p class='bio' style='margin-left: 20px;'>" . htmlspecialchars($row['bio']) . "</p> <!-- Move bio here -->
            </div>
            <div class='modal-footer'>
                <a href='s-sessionform.php?tutor=" . urlencode($row['firstName'] . " " . $row['lastName']) . "' class='btn btn-success'>Book a Session</a>
            </div>
        </div>
    </div>
</div>";





        echo "</div>"; // Closing card-body
        echo "</div>"; // Closing card
        echo "</div>"; // Closing col-md-12
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
