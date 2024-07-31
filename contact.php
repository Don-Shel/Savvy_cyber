<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'php/src/Exception.php';
require 'php/src/PHPMailer.php';
require 'php/src/SMTP.php';

if(isset($_POST["send"])){
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'donselsheldon04@gmail.com';
  $mail->Password = 'Sheldon2379';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 3306;

  $mail->setFrom('sheldonletting0404@gmail.com', 'Sheldon');

  $mail->addAddress($_POST["email"]);

  $mail->isHTML(true);

  $mail->Subject = $_POST["phone"];
  $mail->Body = $_POST["message"];

  $mail->send();

  echo
  "
  <script>
  alert('Email sent successfully');
  window.location.href='index.html';
  </script>
  ";
}

// Configuration
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
//$user_id = rand(200);
$sql = "INSERT INTO contactus (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
// Create a PDO connection object
$conn = new PDO('mysql:host=localhost;dbname=contacts', 'root', '');

// Define the SQL query
$squery = 'SELECT * FROM mytable WHERE id = :id';

// Prepare the SQL statement
$stmt = $conn->prepare($squery);

// Bind a value to the :id parameter
$stmt->bindParam(':id', $id);

// Execute the prepared statement
$stmt->execute();

// Fetch the results
$results = $stmt->fetchAll();

//if ($stmt->execute() === TRUE) {
    echo "<script>
    alert('Thank You for your submition! We'll get back to you soon.');
    window.locaton.href = 'index.html';
    </script>";
 //else {
   // echo "Error: " . $sql . "<br>" . $conn->error;
   // echo "Error: " . $stmt->error;
//}

// Close the database connection
$conn->close();
?>