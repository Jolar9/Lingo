<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();

// For debugging:
// echo $_SESSION['role'];
// echo $_SESSION['firstname'];
// echo $_SESSION['id'];
if (!isset($_SESSION['email']) && ($_SESSION['role']!='tutor')) { // && ($_SESSION['role']!='tutor')
  header("Location: LogInPage.php?error=Please Sign In again!");
  exit();
}

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$firstName = $_SESSION['firstname'];
$lastName = $_SESSION['lastname'];
$email = $_SESSION['email'];
$password = $_POST['password'];
$city = $_SESSION['city'];
$id = $_SESSION['id']; //could cause problems - mixup with users id


// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstName = $_POST['firstname'];
  $lastName = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $city = $_POST['city'];

  if($_SESSION['role']=='tutor'){

$sql = "UPDATE Tutors SET firstname=?, lastname=?, email=?, password=?, city=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $firstName, $lastName, $email, $password, $city, $id);
$sql2 = "UPDATE users SET email=?, password=? WHERE tutor_id=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ssi", $email, $password, $id);

if ($stmt->execute() && $stmt2->execute()) {
  echo "Additional info updated successfully";
  header("Location: TutorHome.php");
  //exit(); 
} else {
  echo "Error updating record: " . $stmt->error;
}

  } else if($_SESSION['role']=='student'){
    $sql = "UPDATE Students SET firstname=?, lastname=?, email=?, password=?, city=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $firstName, $lastName, $email, $password, $city, $id);
    $sql2 = "UPDATE users SET email=?, password=? WHERE student_id=?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ssi", $email, $password, $id);
    
    if ($stmt->execute() && $stmt2->execute()) {
      echo "Additional info updated successfully";
      header("Location: StudentHome.php");
      //exit(); 
    } else {
      echo "Error updating record: " . $stmt->error;
    }

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
    <link rel="stylesheet" href="EditInfo.css" />
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
              <a class="nav-link" href="#">Profile</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <div class="container">
      <h1 class="display-6">Personal information</h1>

      <form action="" method="post">
        <div class="form-group">
          <label for="firstname">First name</label>
          <input
            type="text"
            class="form-control"
            id="firstname"
            name="firstname"
            value="<?php echo $firstName; ?>"
            required
          />
        </div>
        <div class="form-group">
          <label for="lastname">Last name</label>
          <input
            type="text"
            class="form-control"
            id="lastname"
            name="lastname"
            value="<?php echo $lastName; ?>"
            required
          />
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            value="<?php echo $email; ?>"
            required
          />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            value="Jane1234"
            required
          />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="city">City</label>
            <input
              type="text"
              class="form-control"
              id="city"
              name="city"
              value="<?php echo $city; ?>"
              required
            />
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
          <button>Save</button>
          <input type="hidden" name="action" id="action" value=""> 
          <button id="delete" >Delete Account</button>
        </div>
      </form>
    </div>
    <script>
  document.getElementById('delete').addEventListener('click', function() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
      document.getElementById('action').value = 'delete';
      document.querySelector('form').action = 'deleteAccount.php';
      document.querySelector('form').submit();
    }
  });
</script>

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
