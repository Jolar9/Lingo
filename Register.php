<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from Signup1.html
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $city = $_POST['city'];

    // Collect data from Signup2.html
    $languages = $_POST['languages'];
    $level = $_POST['level'];
    $education = $_POST['education'];
    $info = $_POST['info'];

    // Assuming you have a MySQL database
    $servername = "localhost";
    $username = "macbookair";
    $password = "";
    $dbname = "Lingo";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (firstname, lastname, age, gender, email, password, country, city, languages, level, education, info)
    VALUES ('$firstname', '$lastname', '$age', '$gender', '$email', '$password', '$country', '$city', '$languages', '$level', '$education', '$info')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";

        // Redirect to the home page with user info filled in
        header("Location: TutorHome.php?firstname=$firstname&lastname=$lastname&age=$age&gender=$gender&email=$email&country=$country&city=$city&languages=$languages&level=$level&education=$education&info=$info");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
