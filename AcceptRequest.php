<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: LogInPage.php?error=Please Sign In again!");
  exit();
} else {
  $TutorName = $_SESSION['firstname'];
}

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

// Create a mysqli connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $requestID = mysqli_real_escape_string($conn, $_POST['request_id']);

    // Update the status to 'accepted' in the database
    $updateQuery = "UPDATE StudentSession SET status='accepted' WHERE tutor='$TutorName' AND id='$requestID'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Status updated successfully
        echo "Request accepted successfully!";
        header("Location: TutorHome.php");

    } else {
        // Error updating status
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle the case if the form is not submitted via POST method
    echo "Invalid request method.";
}
?>
