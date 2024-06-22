<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['id'])) {
  // Handle the case when 'id' is not set in the session
  die("Session 'id' not set");
}
$id = $_SESSION['id'];


DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

if (!$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME)) {
  die("Connection failed");
}

if (!mysqli_select_db($conn, DB_NAME)) {
  die("Couldn't open the " . DB_NAME . " database");
}

// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $time = $_POST['time'];
  $day = $_POST['day'];

  // Prepare and bind the SQL statement
  $sql = "UPDATE StudentSession SET time=?, day=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $time, $day, $id);

  if ($stmt->execute()) {
    echo "Additional info updated successfully";
    header("Location: selectTutor.php");
    //exit();
  } else {
    echo "Error updating record: " . $stmt->error;
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Learner Registration</title>
  <link rel="stylesheet" type="text/css" href="Time.css">
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..
1000;1,200..1000&family=Open+S
ans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&fami
ly=Raleway:ital,wght@0,100..
900;1,100..900&display=swap" rel="stylesheet" />
  <nav class="nav.navbar">
    <a>lingo</a>
    <a class="active" href="#home">Home</a>
    <a href="#register">Register</a>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
      <a class="navbar-brand" href="#"><img src="IMG_2440-2.svg" width="65" height="50" alt="lingo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">New Request</a>
          </li>
        </ul>

      </div>
    </nav>
  </header>


  <div class="container">
    <div id="border">
      <div class="center">
        <h3 class="display-5">Which time do you prefer?</h3>
      </div>
      <br>



      <div class="centered">
        <form method="post">
          <h5>Times <i class="fa-regular fa-clock"></i></h5>
          <br>
          <div class="select-container">
            <button name="time" value="6-9" tabindex style="font-size:15px ;margin-right: 30px;border-radius: 10px;" onclick="selectTime(this)">6-9 <i class="fa-solid fa-cloud"></i></button>
            <button name="time" value="9-12" style="font-size:15px;margin-right: 30px; border-radius: 10px;" onclick="selectTime(this)">9-12 <i class='fas fa-cloud-sun'></i></button>
            <button name="time" value="12-15" style="font-size:15px ;margin-right: 30px; border-radius: 10px;" onclick="selectTime(this)">12-15 <i class="fas fa-sun"></i></button>
          </div>
          <br>

          <div class="select-container">
            <button name="time" value="15-18" style="font-size:15px;margin-right: 30px; border-radius: 10px;" onclick="selectTime(this)">15-18 <i class="fa-solid fa-sun-plant-wilt"></i></button>
            <button name="time" value="18-21" style="font-size:15px;margin-right: 30px; border-radius: 10px;" onclick="selectTime(this)">18-21 <i class='fas fa-cloud-moon'></i></button>
            <button name="time" value="21-24" style="font-size:15px;margin-right: 30px; border-radius: 10px;" onclick="selectTime(this)">21-23 <i class="fa-solid fa-moon"></i></button>
          </div>
          <br>
          <hr>
          <br>
          <h5>Days <i class="fa-regular fa-calendar-days"></i></h5>
          <br>
          <div class="select-container">

            <label for="days">Choose a day:</label>
            <br>
            <br>
            <br>
            <div class="select">
              <select name="format" id="format">
                <option selected disabled>Select a day</option><br>

                <option name="day" value="Sunday">Sunday</option>
                <option name="day" value="Monday">Monday</option>
                <option name="day" value="Tuesday">Tuesday</option>
                <option name="day" value="Wednsday">Wednesday</option>
                <option name="day" value="Thursday">Thursday</option>
                <option name="day" value="Friday">Friday</option>
                <option name="day" value="Saturday">Saturday</option>

            </div>

            </select>



          </div>
          <br>
          <br>
          <br>
          <br>
          <br>


      </div>
    </div>
    <br>
    <a href="selectTutor.html">
      <div class="button"></div><button type="next" class="next">Next</button>
  </div> </a> </form>
  </div>

  <footer class="footer mt-auto py-3">
    <div class="footer-container">
      <div class="row">
        <div class="col-6 col-md-2 mb-3">
          <h5>About</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Our Story</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Features</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Goals</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Partners</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">FAQs</a>
            </li>
          </ul>
        </div>

        <div class="col-6 col-md-2 mb-3">
          <h5>Tutors</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Register</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Features</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Goals</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Partners</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">FAQs</a>
            </li>
          </ul>
        </div>

        <div class="col-6 col-md-2 mb-3">
          <h5>Students</h5>

          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Packages</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Plans</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Pricing</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">Register</a>
            </li>
            <li class="nav-item mb-2">
              <a href="#" class="nav-link p-0 text-muted">About</a>
            </li>
          </ul>
        </div>

        <div class="col-md-5 offset-md-1 mb-3">
          <form>
            <h5>Subscribe to our newsletter</h5>
            <p>Monthly digest of what's new and exciting from us.</p>
            <div class="d-flex flex-column flex-sm-row w-100 gap-2">
              <label for="newsletter1" class="visually-hidden"></label>
              <input id="newsletter1" type="text" class="form-control" placeholder="Email address" />
              <btn class="btn btn-primary" type="button">Subscribe</button>
            </div>
          </form>
        </div>
      </div>

      <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
        <p>© 2024 lingo, Inc. All rights reserved.</p>
        <ul class="list-unstyled d-flex">
          <li class="ms-3">
            <a class="link-dark" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
              </svg></a>
          </li>
          <li class="ms-3">
            <a class="link-dark" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
              </svg></a>
          </li>
          <li class="ms-3">
            <a class="link-dark" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
              </svg></a>
          </li>
        </ul>
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get the Next button
      var nextBtn = document.querySelector('.next');

      // Add click event listener to the Next button
      nextBtn.addEventListener('click', function() {
        // Check if a time and day are selected
        var selectedTime = document.querySelector('.select-container button.selected');
        var selectedDay = document.getElementById('format').value;

        if (selectedTime && selectedDay) {
          // Submit the form if both time and day are selected
          document.getElementById('timeForm').submit();
        } else {
          alert('Please select both a time and a day before proceeding.');
        }
      });
    });


    function selectTime(button) {
      var buttons = document.querySelectorAll('.select-container button');
      buttons.forEach(function(btn) {
        btn.classList.remove('selected');
      });
      button.classList.add('selected');
    }
  </script>

</body>

</html>