<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'php/src/Exception.php';
require 'php/src/PHPMailer.php';
require 'php/src/SMTP.php';

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

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'donselsheldon04@gmail.com';
    $mail->Password = '2025 8008';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465; // Use 465 for SSL

    $mail->setFrom('donselsheldon04@gmail.com', '');

    // Add the recipient email address
    $recipient_email = 'sheldonletting04@gmail.com';
    $mail->addAddress($recipient_email);

    // Add the CC email address (optional)
   // $cc_email = 'ccemail@example.com';
   // $mail->addCC($cc_email);

    // Add the BCC email address (optional)
    //$bcc_email = 'bccemail@example.com';
    //$mail->addBCC($bcc_email);

    $mail->isHTML(true);

    // Set the email subject and body
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST[ "Name: $name\nEmail: $email\nMessage: $phone\nPhoneNo: $message"];
    //'
       // <h2>New Contact Form Submission</h2>
       // <p>Name: ' . $_POST["name"] . '</p>
       // <p>Email: ' . $_POST["email"] . '</p>
       // <p>Phone: ' . $_POST["phone"] . '</p>
       // <p>Message: ' . $_POST["message"] . '</p>
    //';

    $mail->send();

    echo "
    <script>
    alert('Email sent successfully');
    document.location.href = 'index.php';
    </script>
    ";
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