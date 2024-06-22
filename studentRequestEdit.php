<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email']) && ($_SESSION['role'] != 'student')) { /// ($_SESSION['role']!='student')
  header("Location: LogInPage.php?error=Please Sign In again!");
  exit;
}
DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

if (!$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME)) {
  die("Connection failed");
}

if (!mysqli_select_db($conn, DB_NAME)) {
  die(mysqli_error($conn)); //die("Couldn't open the " . DB_NAME . " database");
}

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

if (!isset($_SESSION['email']) && ($_SESSION['role'] != 'student')) {
  header("Location: LogInPage.php?error=Please Sign In again!");
  exit;
}

$language = $_GET['language'] ?? '';
$tutor = $_GET['tutor'] ?? '';
$day = $_GET['day'] ?? '';
$time = $_GET['time'] ?? '';
$level = $_GET['level'] ?? '';
$duration = $_GET['duration'] ?? '';

$request_id = $_SESSION['request_id'];
// echo $request_id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data

  $firstname = $_SESSION['firstname'];
  $language = $_POST['languages'];
  $level = $_POST['level'];
  $day = $_POST['day'];
  $time = $_POST['time'];
  $duration = $_POST['duration'];
  $tutor = $_POST['tutor'];

  // Update the database record
  $update_query = "UPDATE StudentSession SET student='$firstname', language='$language', level='$level', day='$day', time='$time', duration='$duration', tutor='$tutor' WHERE id='$request_id'";

  if (mysqli_query($conn, $update_query)) {
    header("Location: StudentHome.php");
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Request</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <link rel="stylesheet" href="studentRequestEdit.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
      <img src="IMG_2440-2.svg" width="70" height="55" alt="lingo" />
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Student Request</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <button class="btn signout">Sign out</button>
        </form>
      </div>
    </nav>
  </header>
  <form action="studentRequestEdit.php" method="post">
    <div class="container">
      <h2>Learning Request</h2>
      <div class="request">


        <div class="request-details">
          <div class="form-group">
            <label for="firstname">Name</label>
            <input type="text" class="form-control" id="firstname" value="<?php echo "$firstname $lastname"; ?>" required />
          </div>




          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="languages">Language to Learn</label>
              <select class="form-control" name="languages" id="languages" required>
                <option value="">Language</option>
                <option value="Chinese" <?php if ($language == 'Chinese') echo 'selected'; ?>>Chinese</option>
                <option value="English" <?php if ($language == 'English') echo 'selected'; ?>>English</option>
                <option value="French" <?php if ($language == 'French') echo 'selected'; ?>>French</option>
                <option value="German" <?php if ($language == 'German') echo 'selected'; ?>>German</option>
                <option value="Italian" <?php if ($language == 'Italian') echo 'selected'; ?>>Italian</option>
                <option value="Japanese" <?php if ($language == 'Japanese') echo 'selected'; ?>>Japanese</option>
                <option value="Korean" <?php if ($language == 'Korean') echo 'selected'; ?>>Korean</option>
                <option value="Spanish" <?php if ($language == 'Spanish') echo 'selected'; ?>>Spanish</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="level">Current Level</label>
              <select class="form-control" name="level" id="level" required>
                <option value="" disabled>Level</option>
                <option value="Beginner" <?php if ($level == 'Beginner') echo 'selected'; ?>>Beginner</option>
                <option value="Elementary" <?php if ($level == 'Elementary') echo 'selected'; ?>>Elementary</option>
                <option value="Intermediate" <?php if ($level == 'Intermediate') echo 'selected'; ?>>Intermediate</option>
                <option value="Upper Intermediate" <?php if ($level == 'Upper Intermediate') echo 'selected'; ?>>Upper Intermediate</option>
                <option value="Advanced" <?php if ($level == 'Advanced') echo 'selected'; ?>>Advanced</option>
                <option value="Master" <?php if ($level == 'Master') echo 'selected'; ?>>Master</option>
                <option value="native" <?php if ($level == 'native') echo 'selected'; ?>>native</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="day">Day</label>
              <select class="form-control" name="day" id="day" required>
                <option value="" disabled>Day</option>
                <option value="Sunday" <?php if ($day == 'Sunday') echo 'selected'; ?>>Sunday</option>
                <option value="Monday" <?php if ($day == 'Monday') echo 'selected'; ?>>Monday</option>
                <option value="Tuesday" <?php if ($day == 'Tuesday') echo 'selected'; ?>>Tuesday</option>
                <option value="Wednesday" <?php if ($day == 'Wednesday') echo 'selected'; ?>>Wednesday</option>
                <option value="Thursday" <?php if ($day == 'Thursday') echo 'selected'; ?>>Thursday</option>
                <option value="Friday" <?php if ($day == 'Friday') echo 'selected'; ?>>Friday</option>
                <option value="Saturday" <?php if ($day == 'Saturday') echo 'selected'; ?>>Saturday</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="time">Time</label>
              <select class="form-control" name="time" id="time" required>
                <option value="" disabled>Time</option>
                <option value="6-9" <?php if ($time == '6-9') echo 'selected'; ?>>6-9</option>
                <option value="9-12" <?php if ($time == '9-12') echo 'selected'; ?>>9-12</option>
                <option value="12-15" <?php if ($time == '12-15') echo 'selected'; ?>>12-15</option>
                <option value="15-18" <?php if ($time == '15-18') echo 'selected'; ?>>15-18</option>
                <option value="18-21" <?php if ($time == '18-21') echo 'selected'; ?>>18-21</option>
                <option value="21-24" <?php if ($time == '21-23') echo 'selected'; ?>>21-23</option>
              </select>
            </div>
          </div>

          <label for="duration">Duration</label><br>
          <div class="form-group col-md-12">

            <select class="form-control" name="duration" id="duration">
              <option name="duration" value="" disabled>Duration</option>
              <option name="duration" value="One hour" <?php if ($duration == 'One hour') echo 'selected'; ?>>1 Hour</option>
              <option name="duration" value="Two hours" <?php if ($duration == 'Two hours') echo 'selected'; ?>>2 Hours</option>
              <option name="duration" value="Three hours" <?php if ($duration == 'Three hours') echo 'selected'; ?>>3 Hours</option>
            </select>
          </div>


          <label for="tutor">Select a Tutor</label><br>
          <label for="" style="font-size: smaller;">Browse Tutor List from </label><a href="TutorList.php" style="font-size: smaller;"> Here</a>
          <div class="form-group col-md-12">

            <select class="form-control" name="tutor" id="tutor">
              <option value="" disabled>Tutor</option>
              <option value="Dona" <?php if ($tutor == 'Dona') echo 'selected'; ?>>Dona Albadrani</option>
              <option value="Ruba" <?php if ($tutor == 'Ruba') echo 'selected'; ?>>Ruba Alhuwaidi</option>
              <option value="Ryoof" <?php if ($tutor == 'Ryoof') echo 'selected'; ?>>Ryoof Altassan</option>
              <option value="Joud" <?php if ($tutor == 'Joud') echo 'selected'; ?>>Joud Alatiah</option>
            </select>
          </div>
          <div class="button-container">
            <button class="btn" type="submit">Save</button>
            <button class="btn" id="reject">Delete</button>
          </div>
        </div>
      </div>
  </form>


  <script>
    // JavaScript function to handle deletion
    function confirmDelete() {
      return confirm("Are you sure you want to delete this request?");
    }

    // Event listener for delete button
    document.getElementById("reject").addEventListener("click", function() {
      if (confirmDelete()) {
        // Send AJAX request to deleteRequest.php
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "deleteRequest.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Check the response from deleteRequest.php
            if (xhr.responseText.trim() === "success") {
              // Redirect or perform any action after successful deletion
              window.location.href = "StudentHome.php";
            } else {
              alert("Error deleting record");
            }
          }
        };
        xhr.send();
      }
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>