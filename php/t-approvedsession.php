<?php

echo "<style type='text/css'>

.profile-picture {
  margin: 0;
  max-width: 200px;
  max-height: 200px;
  width: 160px; /* Set a fixed width */
  height: 160px; /* Set a fixed height */
  object-fit: cover; /* Maintain aspect ratio and cover the container */
}
.tutorName{
  position:absolute; 
  top:10%; 
  left:5%; 
  margin-left:0px; 
  margin-right:0px; 
  font-size: 20px;
}
.degreeProgram{
  position:absolute; 
  top:25%; 
  left:17%; 
  margin-left:0px; 
  margin-right:0px; 
  font-size: 15px;
  width: 100%;
}
.icongrad{
  width: 33px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */
  position:relative; 
  margin-bottom:0.5%;
  margin-left: 1%;
}
.mode{
  position:absolute; 
  top:30%; 
  left:3.5%; 
  margin-left:1px; 
  margin-right:0px; 
  font-size: 15px;
  width: 100%;
}
.iconmode{
  width: 20px; 
  height: 20px; 
  position:relative; 
  margin-bottom:0.5%;
  margin-right:0.5%;
  margin-left: 1%;
  object-fit: cover;
}
.subj{
  position:absolute; 
  top:45%; 
  left:3.5%; 
  margin-left:1px; 
  margin-right:0px; 
  font-size: 15px;
  width: 100%;
  
}
.iconsubj{
  width: 19px; /* Set a fixed width */
  height: 20px; /* Set a fixed height */
  position:relative; 
  margin-bottom:0.5%;
  margin-right:0.5%;
  margin-left: 1%;
  object-fit: cover;
}
.bio{
  position: absolute;
  top: 20%;
  left: 49%;
  margin-left: 1px;
  margin-right: 0px;
  font-size: 15px;
  width: 58%;
  color: #666; /* Grey font color */
  font-style: italic; /* Italic font */
}
.btn-outline-custom1,
.btn-outline-custom2 {
    color: #0F422A;
    background-color: #ffffff;
    border-color: #0F422A;
    font-weight: bold;
    letter-spacing: 0.05em;
    position: absolute;
    left: 80%;
    width: 200px; /* Adjust width as needed */
}

.btn-outline-custom1 {
    top: 20%;
}

.btn-outline-custom2 {
    top: 49%;
}
.rate{
  top:80%;
  left:4.5%;
  width:200px;
  height:40px;
  position: absolute;
  z-index: 2;
  font-size: 15px;
  font-weight: 600;

}

.modal-body {
    padding-left: 50px;  
    padding-right: 50px;
}

.modal-content {
  border-radius: 25px; 
  border: none; 
}

.modal-header {
    border-bottom: none; 
}

.modal-text{
color: #0f422a;
font-size:20px;
}

.modal-text:last-child {
    margin-bottom:60px; 
}

.modal-textmain{
color: #0f422a;
font-size:25px;
margin-left: -10px; 
margin-top:-20px;
}

.close {
  font-size: 4rem; 
  color: #0F422A; 
  font-weight: 300;
  margin:0;
}


</style>";

// Retrieve logged-in tutor's tutorID
$tutorID = $_SESSION['auth_tutor']['tutor_id'];
// Query to fetch sessions for the logged-in tutor with student names, ordered by nearest session date
$sql = "SELECT s.sessionID, DATE_FORMAT(s.sessionDate, '%M %e, %Y') AS formattedSessionDate, TIME_FORMAT(s.startTime, '%h:%i %p') AS formattedStartTime, TIME_FORMAT(s.endTime, '%h:%i %p') AS formattedEndTime, s.duration, s.subject, s.teachingMode, s.need, s.paymentStatus, 
    CASE
        WHEN s.status = 'Approved' THEN 'Paid'
        ELSE s.status
    END AS status,
    CONCAT(st.firstname, ' ', st.lastname) AS studentFullName, st.degreeProgram, st.year, t.ratePerHour
FROM session s
INNER JOIN student st ON s.studentID = st.studentID
INNER JOIN tutor t ON s.tutorID = t.tutorID
WHERE s.tutorID = ? AND (s.status = 'Approved' OR s.status = 'Waiting for Payment')
ORDER BY s.sessionDate ASC"; // Order by session date in ascending order

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tutorID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the prepare statement was successful
if (!$stmt) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $tutorID);
$stmt->execute();

// Check if the execute statement was successful
if ($stmt->error) {
    die("Execute failed: " . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();

// Check if the query was successful
if ($result) {
    // Loop through the result set and display the data
    while ($row = mysqli_fetch_assoc($result)) {
        $sessionID = $row['sessionID'];
    

        echo "<div class='col-md-12 mb-3' style = 'margin-left:0px; width:100% !important;'>";
        echo "<div class='card shadow custom-card' style='height: 200px; margin-top: 1%;'>";
        echo "<div class='card-body'>";

        echo "<h4 class='tutorName'>" . $row['studentFullName']  ."</h4>";
        
        echo "<p class='mode'>" . "<img src = 'icons/mode.png' class = 'iconmode'/>"  . $row['teachingMode'] . "  ". "<strong>|</strong>" . "  ". $row["formattedSessionDate"] .  "  ". "<strong>|</strong>" . "  " .   $row["formattedStartTime"] ." - ".   $row["formattedEndTime"] ."</p>";
        echo "<p class='subj'> " . "<img src = 'icons/subj.png' class = 'iconsubj'/>"  . $row['subject'] . "</p>";
        
        echo "<p class = 'bio'>Status: <br>" . $row['status'] . "</p>";

        echo "<p class= 'rate'>Total Cost: ₱" . number_format($row['duration'] * $row['ratePerHour'], 2) . "</p>";

        echo "<button type='button' class='btn btn-outline-custom1' data-toggle='modal' data-target='#detailsModal{$sessionID}'>View Details</button><br><br>";
     
       // Display "Mark as Finished" button if the session status is "Paid"
       if ($row['status'] == 'Paid') {
        echo "<a href='#'>
        <button class='btn btn-outline-custom2'>Mark as Finished</button>
      </a><br><br>";
    }

        
       

        echo "</div>";
        echo "</div>";
        echo "</div>";

                // Modal for "View Details"
                echo "
                <div class='modal fade' id='detailsModal{$sessionID}' tabindex='-1' role='dialog' aria-labelledby='detailsModalLabel{$sessionID}' aria-hidden='true'>
                  <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body'>
                        <p class='modal-textmain'><strong>Student: " . htmlspecialchars($row['studentFullName']) . " </strong></p>
                        <p class='modal-text'>Program: " . htmlspecialchars($row['degreeProgram']) . "</p>
                        <p class='modal-text'>Teaching Mode: " . htmlspecialchars($row['teachingMode']) . "</p>
                        <p class='modal-text'>Subject: " . htmlspecialchars($row['subject']) . "</p>
                        <p class='modal-text'>Date: " . htmlspecialchars($row['formattedSessionDate']) . "</p>
                        <p class='modal-text'>Time: " . htmlspecialchars($row['formattedStartTime']) . " - " . htmlspecialchars($row['formattedEndTime']) . "</p> <br>
                        <p class='modal-text'>Need: " . htmlspecialchars($row['need']) . "</p>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                ";       
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
