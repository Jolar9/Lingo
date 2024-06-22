<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $rating = $_POST['rating'];
  $tutor_name = $_POST['tutor'];
  $student_name = $_SESSION['firstname'];
  $review_text = $_POST['review'];

  if ($rating !== false && $rating >= 1 && $rating <= 5 && $tutor_name && $review_text && $student_name) {
    $stmt = $conn->prepare("INSERT INTO reviews (rating, tutor_name, student_name, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $rating, $tutor_name, $student_name, $review_text);
    
    // Execute the insert query
    $stmt->execute();

    $stmt->close();
  } else {
    echo "Invalid input data!";
  }
}

$query = "SELECT * FROM Tutors";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Review Tutor</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <link rel="stylesheet" href="review.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <script src="stars.js" defer></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
      <img src="IMG_2440-2.SVG" width="70" height="55" alt="lingo" />
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Review Tutor</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <button class="btn signout">Sign out</button>
        </form>
      </div>
    </nav>
  </header>

  <div class="container">
    <h2>Rate your Tutor</h2>

    <div class="request">
      <form action="" method="post"> <!-- Update the action attribute to an empty string -->
        <div class="request-details">

          <div class="form-group">
          <label for="tutor">Select a Tutor</label>
            <label for="" style="font-size: smaller;">Note: only tutors of completed sessions are displayed here</label>
            <select class="form-control" name="tutor" id="tutor">
              <option value="" disabled selected>Tutor</option>
              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $tutor_id = $row['id'];
                  $tutor_name = $row['firstname'];
                  echo "<option name=tutor value='$tutor_name'>$tutor_name</option>";
                }
              } else {
                echo "<option value=''>No tutors available</option>";
              }
              ?>
              
              
            </select>
            <br>

            <input type="hidden" name="rating" id="rating" value="0" />
            <div class="rating-box">

              <div class="stars">
                <i class="fa-solid fa-star" onclick="setRating(1)"></i>
                <i class="fa-solid fa-star" onclick="setRating(2)"></i>
                <i class="fa-solid fa-star" onclick="setRating(3)"></i>
                <i class="fa-solid fa-star" onclick="setRating(4)"></i>
                <i class="fa-solid fa-star" onclick="setRating(5)"></i>
              </div>
            </div>
            
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="review">Overall, how would you rate your learning experience in this tutor's session?</label>
              <textarea class="form-control" name="review" id="review" cols="42" rows="5" required></textarea>
            </div>
          </div>

          <div class="button-container">
            <button type="submit" class="btn submit">Submit</button>
          </div>

        </div>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>
