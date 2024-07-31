<?php

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

// Define the contact form handler function
function handleContactFormSubmission($name, $email, $phone, $message) {
    global $conn;

    // Validate user input
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        return array('error' => 'Please fill in all fields.');
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return array('error' => 'Invalid email address.');
    }

    // Insert submission into database
    $query = "INSERT INTO contactus (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $phone, $message);
    $stmt->execute();
    
    // Send email to Savvy Cyber
    $to = 'sheldonletting04@gmail.com';
    $subject = 'Contact Form Submission';
    $body = "Name: $name\nEmail: $email\nMessage: $phone\nPhoneNo: $message";
    mail($to, $subject, $body);

    return array('success' => 'Thank you for your submission!');
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $response = handleContactFormSubmission('sss',$name, $email, $phone, $message);

    if (isset($response['error'])) {
        echo json_encode(array('error' => $response['error']));
    } else {
        echo json_encode(array('success' => $response['success']));
    }

    echo "Thank you for contacting us we will get to you soon!";
}

// Close the database connection
$conn->close();
?>
