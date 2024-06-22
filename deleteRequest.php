<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email']) && ($_SESSION['role'] != 'student')) { /// ($_SESSION['role']!='student')
    header("Location: LogInPage.php?error=Please Sign In again!");
    exit;
}

$request_id = $_SESSION['request_id'];
echo  $request_id;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    $delete_query = "DELETE FROM StudentSession WHERE id='$request_id'";

    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['request_id'] -= 1;
        echo "Record deleted successfully";
        header("Location: StudentHome.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
