<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// || ($_SESSION['role'] != 'tutor' && $_SESSION['role'] != 'student')

if (!isset($_SESSION['email'])) {
    header("Location: index.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    
DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'Lingo');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

    
    $id = $_SESSION['id'];
    
    // deletion based on user's role
    if ($_SESSION['role'] == 'tutor') {
        // delete from table Tutors
        $sql = "DELETE FROM Tutors WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        // delete from table users
        $sql2 = "DELETE FROM users WHERE tutor_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $id);

    } else if ($_SESSION['role'] == 'student') {
        // delete from table Students
        $sql = "DELETE FROM Students WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        // delete from table users
        $sql2 = "DELETE FROM users WHERE student_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $id);
    }

    
    if ($stmt->execute()) {
        
        session_unset();
        session_destroy();
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error deleting account: " . $stmt->error;
    }
} else {
    header("Location: index.php"); 
    exit();
}
?>

