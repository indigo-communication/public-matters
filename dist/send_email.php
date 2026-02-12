<?php
/**
 * Contact Form Email Handler for Public Matters Lebanon
 * Sends emails from contact form to julie.bouchakra@publicmatterslebanon.org
 */

// Set content type to JSON
header('Content-Type: application/json');

// Allow CORS for local testing
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$name = isset($_POST['Name']) ? trim($_POST['Name']) : '';
$email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
$message = isset($_POST['Message']) ? trim($_POST['Message']) : '';

// Validate inputs
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (empty($message)) {
    $errors[] = 'Message is required';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Recipient email
$to = 'julie.bouchakra@publicmatterslebanon.org';

// Email subject
$subject = 'New Contact Form Submission from ' . $name;

// Email body
$email_body = "You have received a new message from the website contact form.\n\n";
$email_body .= "Name: " . $name . "\n";
$email_body .= "Email: " . $email . "\n\n";
$email_body .= "Message:\n" . $message . "\n";

// Email headers
$headers = "From: noreply@publicmatterslebanon.org\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $email_body, $headers)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for the time submitting your message!'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to send email. Please try again later.'
    ]);
}
