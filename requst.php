<?php


    //Configuration
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'work';

    // Create a connection to the database
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Cheking the connection
    if ($conn->connect_error){
      die("connection failed: " .$conn->connect_error);
    }
 
    //Define the contact form handler function
    function handleContactFormSubmission($name, $contactPerson, $email, $phone, $workType, $workDescription, $file){
        global $conn;

        //validate user input
        if (empty($name) || empty($contact_person) || empty($email) || empty($phone) || empty($work_type) || empty($work_description)) {
            return array('error' => 'PLease fill in all fields.');
        }

        //Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
          return array('error' => 'Invalid email address.');
        }

        // Insert submission into database
        $query = "INSERT INTO work_request (name, contact_person, email, phone, work_type, work_description, file) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $name, $contactPerson, $email, $phone, $workType, $workDescription, $file);
        $stmt->execute();
        
        // Send email to Savvy Cyber
        $to = 'sheldonletting04@gmail.com';
        $subject = 'Work Request Form Submission';
        $body = "Name: $name\nEmail: $contactPerson\nMessage: $email\nMessage: $phone\nMessage: $workType\nMessage: $workDescription\nMessage: $file\nMessage";
        mail($to, $subject, $body);

        return array('success' => 'Thank you for your submission! We will notify you when its done...Feel free to contact us for any modifications. Thank you!');
    }


    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get the form data
      $name = $_POST["name"];
      $contactPerson = $_POST["contact_person"];
      $email = $_POST["email"];
      $phone = $_POST["phone"];
      $workType = $_POST["work_type"];
      $workDescription = $_POST["work_description"];
      $file = $_POST["file"];
      
      // Process the form data
      // ...
      $response = handleContactFormSubmission($name, $contactPerson, $email, $phone, $workType, $workDescription, $file);

      if (isset($response['error'])) {
          echo json_encode(array('error' => $response['error']));
      } else {
          echo json_encode(array('success' => $response['success']));
      }
      
      
      // Send a response to the user
      echo "Thank you for submitting your work request!";
    }

    // Close the database connection
$conn->close();
?>

