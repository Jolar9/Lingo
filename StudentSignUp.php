<?php
var_dump($_POST);
session_start();

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

if (!$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME)) {
  die("Connection failed");
}

if (!mysqli_select_db($conn, DB_NAME)) {
  die(mysqli_error($conn));//die("Couldn't open the " . DB_NAME . " database");
}
echo "success";
// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $age = $_POST["age"];
  $gender = $_POST["gender"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $country = $_POST["country"];
  $city = $_POST["city"];
  // $avatar = $_POST["avatar"];

      // Get the latest tutor_id
      $result = $conn->query("SELECT MAX(student_id) as max_id FROM users WHERE role = 'student'");
      $row = $result->fetch_assoc();
      $student_id = $row['max_id'] + 1;


  $sql = "INSERT INTO Students (firstname, lastname, age, gender, email, password, country, city) VALUES ('$firstname', '$lastname', '$age', '$gender', '$email', '$password', '$country', '$city')"; //age
  $sql2 = "INSERT INTO users (email, password, role, student_id) VALUES ('$email', '$password', 'student', $student_id)";
  if (($conn->query($sql) && $conn->query($sql2) )  === TRUE) {
    echo "New record created successfully";
    // $conn->query("COMMIT");
    $id = $conn->insert_id;

        // Store the ID in the session
    $_SESSION['id'] = $id; // changed it in tutor signup, but i dont think id is needed here so i didnt change it
    header("Location: StudentHome.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    echo "Error: " . $sql2 . "<br>" . $conn->error;
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
    <link rel="stylesheet" href="Signup1.css" />
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
              
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Register</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <div class="container">
      <h1 class="display-5">Become a Studnet!</h1>
      <form form method="post">
        <div class="form-group">
          <label for="firstname">First name</label>
          <input type="text" class="form-control" id="firstname" name="firstname"  />
        </div>
        <div class="form-group">
          <label for="lastname">Last name</label>
          <input type="text" class="form-control" id="lastname" name="lastname"  />
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="age">Age</label>
            <input
              type="text"
              class="form-control"
              name="age"
              id="age"
              
            />
          </div>
          <div class="form-group col-md-6">
            <label for="gender">Gender</label>
            <select class="form-control" name="gender" id="gender" >
              <option value="">Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email"  />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password"  />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="country">Country</label>
            <select class="form-control" name="country" id="country" >
              <option>select country</option>
              <option value="AF">Afghanistan</option>
              <option value="AX">Aland Islands</option>
              <option value="AL">Albania</option>
              <option value="DZ">Algeria</option>

            </select>
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city"  />
          </div>
          <div class="form-group">
            <label for="avatar">Choose a profile picture (optional) :</label>
            <input
              type="file"
              id="avatar"
              name="avatar"
              accept="image/png, image/jpeg"
            />
          </div>
        </div>

        <div class="form-row">
          <button>Next</button>
        </div>
      </form>
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

    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent the form from submitting

      // Validation logic
      const firstname = form.querySelector("#firstname").value.trim();
      const lastname = form.querySelector("#lastname").value.trim();
      const age = form.querySelector("#age").value.trim();
      const gender = form.querySelector("#gender").value;
      const email = form.querySelector("#email").value.trim();
      const password = form.querySelector("#password").value.trim();
      const country = form.querySelector("#country").value;
      const city = form.querySelector("#city").value.trim();
      const avatar = form.querySelector("#avatar").value;

      if (!firstname || !lastname || !age || !gender || !email || !password || !country || !city) {
        alert("Please fill in all fields.");
        return;
      }

      if (avatar && !isValidImageType(avatar)) {
        alert("Please upload a valid image (PNG or JPEG).");
        return;
      }

      // If all validations pass, submit the form
      form.submit();
    });

    // Function to check if the uploaded file is an image
    function isValidImageType(file) {
      const allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
      return allowedExtensions.test(file);
    }
  });
</script>

  </body>
</html>
