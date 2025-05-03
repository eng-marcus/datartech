<?php
// contact.php

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $name    = strip_tags(trim($_POST["name"] ?? ""));
    $email   = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"] ?? ""));

    // Validate
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and provide a valid email.";
        exit;
    }

    // Email settings
    $to = "info@datartech.com"; // Replace with your email
    $subject = "New Contact Message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $name <$email>";

    // Attempt to send the email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: thank-you.html");
exit;

    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
