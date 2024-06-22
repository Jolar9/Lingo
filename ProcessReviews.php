<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email']) && ($_SESSION['role']!='tutor')) { // && ($_SESSION['role']!='tutor')
    header("Location: LogInPage.php?error=Please Sign In again!");
    exit();
  }
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    DEFINE('DB_USER', 'root');
    DEFINE('DB_PSWD', '');
    DEFINE('DB_HOST', 'localhost');
    DEFINE('DB_NAME', 'Lingo');
    
    // Create a mysqli connection
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
    
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
echo "hi";
    $rating = $_POST['rating'];
    $tutor_name = $_POST['tutor'];
    $student_name = $_SESSION['firstname']; // Assuming you have a way to get the student's name
    $review_text = $_POST['review'];

    echo $rating;

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO reviews (rating, tutor_name, student_name, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $rating, $tutor_name, $student_name, $review_text);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if the form is not submitted
    header("Location: review.php");
    exit();
}
?>
