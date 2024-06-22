<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: LogInPage.php?error=Please Sign In again!");
  exit();
}
$TutorName = $_SESSION['firstname'];

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

// Create a mysqli connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Request</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="Request.css" />
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
        <img src="IMG_2440-2.svg" width="70" height="55" alt="lingo" />
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
      <h2>Learning Request</h2>
      
      <div class="request">
        <div class="request-details">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="40"
            height="40"
            fill="currentColor"
            class="bi bi-person-fill"
            viewBox="0 0 16 16"
          >
            <path
              d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"
            />
          </svg>
          <?php

            if (isset($_GET['id'])) { // not sure about id retreival

                $requestID = mysqli_real_escape_string($conn, $_GET['id']);

                $query = "SELECT * FROM StudentSession WHERE tutor='$TutorName' AND id='$requestID'";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    echo "<p><strong>Name:</strong> {$row['student']}</p>";
                    echo "<p><strong>Language:</strong> {$row['language']}</p>";
                    echo "<p><strong>Level:</strong> {$row['level']}</p>";
                    echo "<p><strong>Preferred Time:</strong> {$row['time']}</p>";
                    echo "<p><strong>Duration:</strong> {$row['duration']}</p>";
                } else {
                    echo "<p>No request found.</p>";
                }
            } else {
                echo "<p>Request ID is missing.</p>";
            }
            ?>
        </div>
        <div class="button-container" >
          <!-- <button class="btn">Accept</button> -->
          <form action="AcceptRequest.php" method="POST" style="display: inline;">
    <input type="hidden" name="request_id" value="<?php echo $requestID; ?>">
    <button type="submit" class="btn">Accept</button>
</form>

          <!-- <button class="btn" id="reject">Reject</button> -->
          <form action="RejectRequest.php" method="POST" style="display: inline;">
    <input type="hidden" name="request_id" value="<?php echo $requestID; ?>">
    <button type="submit" class="btn" id="reject">Reject</button>
</form>

        </div>
      </div>
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
