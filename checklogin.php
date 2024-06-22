<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('CONFIG-DB.php');

if (isset($_POST['email'])) {
    $con = mysqli_connect(DBHOST, DBUSER, DBPSWD, DBNAME);

if (mysqli_connect_errno()) {  // Removed the argument from mysqli_connect_errno()
    die("Fail to connect to database :" . mysqli_connect_error());
}
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);


    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_id'] = $row['id'];  //user_id : id from 'users' table, any other reference of 'id' is related to either student id or tutor id

        echo $_SESSION['role'];
        echo $_SESSION['email'];
        //header("Location: TutorHome.php");
        //$row = mysqli_fetch_assoc($result);
         if ($password == $row['password']) {
            // $_SESSION['email'] = $row['email'];
            // $_SESSION['role'] = $row['role'];

            if ($_SESSION['role'] == 'student') {

                $queryS = "SELECT * FROM Students WHERE email='$email'";
                $resultS = mysqli_query($con, $queryS);
                $rowS = mysqli_fetch_assoc($resultS);

                $_SESSION['firstname'] = $rowS['firstname'];
                $_SESSION['lastname'] = $rowS['lastname'];
                $_SESSION['age'] = $rowS['age'];
                $_SESSION['gender'] = $rowS['gender'];
                $_SESSION['city'] = $rowS['city'];
                $_SESSION['country'] = $rowS['country'];
                // $_SESSION['password'] = $rowS['password']; ///
                $_SESSION['id'] = $rowS['id'];

                mysqli_close($con);
                header("Location: StudentHome.php");
                exit;

            } else if ($_SESSION['role'] == 'tutor') {
                $queryT = "SELECT * FROM Tutors WHERE email='$email'";
                $resultT = mysqli_query($con, $queryT);
                $rowT = mysqli_fetch_assoc($resultT);

                $_SESSION['firstname'] = $rowT['firstname'];
                $_SESSION['lastname'] = $rowT['lastname'];
                $_SESSION['country'] = $rowT['country'];
                $_SESSION['city'] = $rowT['city'];
                $_SESSION['languages'] = $rowT['languages'];
                $_SESSION['level'] = $rowT['level'];
                $_SESSION['education'] = $rowT['education'];
                // $_SESSION['password'] = $rowT['password'];
                $_SESSION['id'] = $rowT['id'];


                mysqli_close($con);
                header("Location: TutorHome.php");
                exit;
            }
        } else {
            mysqli_close($con);
            header("Location: LogInPage.php?error=Wrong Password");
            exit;
        }
    } else {
        mysqli_close($con);
        header("Location: LogInPage.php?error=Username not found");
        exit;
    }
} else {
    header("Location: LogInPage.php?error=Missing data");
    exit;
}

?>