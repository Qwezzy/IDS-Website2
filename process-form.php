<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize and validate input
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Initialize variables
    $name = $company = $email = $message = "";
    $errors = [];

    // Validate and sanitize form data
    if (empty($_POST['name'])) {
        $errors[] = "Name is required";
    } else {
        $name = test_input($_POST['name']);
    }

    if (empty($_POST['company'])) {
        $errors[] = "Company name is required";
    } else {
        $company = test_input($_POST['company']);
    }

    if (empty($_POST['email'])) {
        $errors[] = "Email is required";
    } else {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }

    if (empty($_POST['message'])) {
        $errors[] = "Message is required";
    } else {
        $message = test_input($_POST['message']);
    }

    // If there are no errors, send email
    if (empty($errors)) {
        // Set recipient email address
        $to = "sales@intermediateds.co.za";

        // Set email subject
        $subject = "Contact Form Submission";

        // Compose email message
        $email_message = "Name: $name\n";
        $email_message .= "Company: $company\n";
        $email_message .= "Email: $email\n\n";
        $email_message .= "Message:\n$message";

        // Set headers
        $headers = "From: $email";

        // Send email
        if (mail($to, $subject, $email_message, $headers)) {
          // Redirect user to thank you page
          header("Location: thank_you.php");
          exit();
      }
      
    } else {
        // Output errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
