<?php

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//use PHPMailer\PHPMailer\SMTP;

//require 'php/src/Exception.php';
//require 'php/src/PHPMailer.php';
//require 'php/src/SMTP.php';

//Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'contacts';

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the form fields
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Validate the form fields
if (empty($name) || empty($email) || empty($message)) {
    echo "Please fill in all the required fields.";
    exit;
}

// Insert the form data into the database
$stmt = $conn->prepare("INSERT INTO contactus (name, email, phone, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $phone, $message);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>
    alert('Thank You for your submission! We'll get back to you soon.');
    window.location.href = 'index.html';
    </script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the database connection
$conn->close();
?>