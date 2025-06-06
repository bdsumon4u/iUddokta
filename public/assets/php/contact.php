<?php

// Only process POST reqeusts.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim((string) $_POST['name']));
    $name = str_replace(["\r", "\n"], [' ', ' '], $name);
    $email = filter_var(trim((string) $_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = trim((string) $_POST['message']);

    // Check that data was sent to the mailer.
    if (empty($name) or empty($message) or ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo 'Please complete the form and try again.';
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = 'email@gmail.com';

    // Set the email subject.
    $subject = "New contact from $name";

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $email_headers, $email_content)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo 'Thank You! Your message has been sent.';
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo 'There was a problem with your submission, please try again.';
}

?>

