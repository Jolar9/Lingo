<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['id'])) {
  // Handle the case when 'id' is not set in the session
  die("Session 'id' not set");
}
$id = $_SESSION['id'];
echo $_SESSION['firstname'];
echo $_SESSION['id'];
$firstname = $_SESSION['firstname'];


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
    $languages = $_POST['languages'];
    $level = $_POST['level'];
    $education = $_POST['education'];
    $info = $_POST['info'];

   // Prepare and bind the SQL statement
$sql = "UPDATE Tutors SET languages=?, level=?, education=?, info=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $languages, $level, $education, $info, $id);

if ($stmt->execute()) {
    echo "Additional info updated successfully";
    header("Location: TutorHome.php");
    //exit(); // Make sure to exit after redirection
} else {
    echo "Error updating record: " . $stmt->error;
}

}
$conn->close(); 
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="Signup2.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <img src="IMG_2440-2.SVG" width="70" height="55" alt="lingo" />
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#"
                >Home <span class="sr-only">(current)</span></a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Register</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <div class="container">
      <h1 class="display-5">Become a Tutor!</h1>
      <h4>2. Experience</h4>

      <form action="Signup2.php" method="post" >
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="languages">Languages spoken</label>
            <select
              class="form-control"
              name="languages"
              id="languages"
              required
            >
              <option value="">Language</option>
              <option value="Chinese">Chinese</option>
              <option value="English">English</option>
              <option value="Arabic">Arabic</option>
              <option value="French">French</option>
              <option value="German">German</option>
              <option value="Italian">Italian</option>
              <option value="Japanese">Japanese</option>
              <option value="Korean">Korean</option>
              <option value="Spanish">Spanish</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="level">Level</label>
            <select class="form-control" name="level" id="level" required>
              <option value="">Level</option>
              <option value="A1">A1</option>
              <option value="A2">A2</option>
              <option value="B1">B1</option>
              <option value="B2">B2</option>
              <option value="C1">C1</option>
              <option value="C2">C2</option>
              <option value="native">native</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="edu">Education</label>
          <select class="form-control" name="education" id="edu" required>
            <option value="">level of education</option>
            <option value="hd">Highschool diploma</option>
            <option value="bd">Bachelor's degree</option>
            <option value="md">Master's degree</option>
            <option value="dd">Doctorate degree</option>
          </select>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="info">Tell us about your cultural knowledge:</label>
            <textarea
              class="form-control"
              name="info"
              id="info"
              cols="42"
              rows="5"
              required
            ></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input
              type="checkbox"
              class="custom-control-input"
              id="tos"
              required
            />
            <label class="custom-control-label" for="tos"
              >I agree to the <a href="">terms of service</a></label
            >
          </div>
        </div>

        <button type="submit">Register</button>
      </form>
      <a href="index.html"><button id="back">Back</button></a>
    </div>
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
      integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
