<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['id'])) {

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

$query = "SELECT * FROM Tutors";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tutor = $_POST['tutor'];



  $sql = "UPDATE StudentSession SET tutor=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $tutor, $id);

  if ($stmt->execute()) {
    echo "Additional info updated successfully";
    header("Location: studentHome.php");
    //exit();
  } else {
    echo "Error updating record: " . $stmt->error;
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leaener Registration</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <link rel="stylesheet" href="selectTutor.css" />
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

  <div class="container">
    <h3>Choose one of our Tutors!</h3>
    <form method="post">
      <div class="request">
        <div class="request-details">
          <h5>
            Browse Tutor List from
            <a href="TutorList.php"> Here</a>
          </h5>


          <div class="form-group col-md-12">
          <select class="form-control" name="tutor" id="tutor">
              <option value="" disabled selected>Select Tutor</option>
              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $tutor_id = $row['id'];
                  $tutor_name = $row['firstname'];
                  echo "<option value='$tutor_name'>$tutor_name</option>";
                }
              } else {
                echo "<option value=''>No tutors available</option>";
              }
              ?>
            </select>
          </div>

          <div class="button-container">
            <a href="StudentHome.html"><button class="btn submit">Submit</button></a>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>