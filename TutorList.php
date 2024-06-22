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

$student = $_SESSION['firstname'];


if (!isset($_SESSION['email']) && ($_SESSION['role'] != 'student')) {
  header("Location: LogInPage.php?error=Please Sign In again!");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="web.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="StudentHome.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&amp;family=Op
en+S
ans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,
100..
900;1,100..900&display=swap" rel="stylesheet" />
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
            <a class="nav-link" href="StudentHome.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tutors</a>
          </li>
        </ul>

        <form class="form-inline mt-2 mt-md-0">
          <button class="btn signout">Sign out</button>
        </form>
      </div>
    </nav>
  </header>

  <nav class="secondary-navbar">
    <section class="filters">
      <div class="search-bar">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" />
        <button class="btn btn-primary" type="button">Search</button>
      </div>
      <div class="custom-dropdown">
        <button class="lesson-time-btn">Select Lesson Time</button>
        <div class="popup-schedule" id="popup-schedule">
          <!-- Popup schedule content goes here -->
        </div>
      </div>
      <div class="custom-dropdown">
        <select class="language-dropdown">
          <option value="language" disabled selected>Select Language</option>
          <option value="english">English</option>
          <option value="spanish">Spanish</option>
          <option value="french">French</option>
          <option value="german">German</option>
          <option value="chinese">Chinese</option>
          <option value="japanese">Japanese</option>
          <option value="arabic">Arabic</option>
          <option value="italian">Italian</option>
          <option value="portuguese">Portuguese</option>
          <!-- Add more languages as needed -->
        </select>
      </div>
      <div class="custom-dropdown">
        <div class="sort-btn" id="sortButton">Sort by</div>
        <div class="sort-options" id="sortOptions">
          <div class="sort-option" data-sort="rate">Rate</div>
          <div class="sort-option" data-sort="price">Price</div>
        </div>
      </div>
    </section>
  </nav>

  <section id="teacher-list">
    <!-- Teacher Card 1 -->

    <?php
    $query = "SELECT * FROM Tutors";
    $result = mysqli_query($conn, $query);

    if (!$result) {
      die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $tutor_id=$row['id'];
        echo "<div class='teacher-card'>";
    echo "<img src='figure.svg' alt='Teacher Image 1' class='avatar'/>";
    echo "<div class='teacher-info'>";
    echo "<h2>
    {$row['firstname']} {$row['lastname']}
      <img
        src='{$row['languages']}.svg'
        alt='Flag Icon'
        class='flag-icon'
      />
    </h2>";
    echo "<p>
    certified Native {$row['languages']} tutor, teaching students from all over the
    world . Hello there . My name is Joud and I am a Saudi native,
    {$row['languages']} is my first language. I seek to teach {$row['languages']} and empower my
    students to confidently speak as best they can and look forward to
    meeting you and teaching you . I have completed m TESOL/TEFL
    certificate to teach, and I am an {$row['languages']} native..
  </p>";
    echo "<p>Languages Spoken: {$row['languages']}</p>";
    echo "<p>Price: $20/hour</p>";
    echo "</div>";
    echo " <div class='actions'>
    <a href='language.php'><button class='view-btn'>book</button></a>
    <a href='TutorDetails.php?id=$tutor_id'><button class='view-btn'>View</button></a>

  </div>";
    echo "</div>";
      }
    } else {
      echo "<p>No upcoming sessions.</p>";
    }

    
    ?>
  
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
              <button class="btn btn-primary" type="button">Subscribe</button>
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
    // Get the profile icon and dropdown content
    const profileIcon = document.querySelector(".profile-icon");
    const dropdownContent = document.querySelector(".dropdown-content");

    // Toggle the display of the dropdown content on profile icon hover
    profileIcon.addEventListener("mouseover", () => {
      dropdownContent.style.display = "block";
    });

    profileIcon.addEventListener("mouseout", () => {
      dropdownContent.style.display = "none";
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>