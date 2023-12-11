<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user details from the form
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Define the recipient's email address
    $to = "recipient@example.com";

    // Define the sender's email address
    $from = "sender@example.com";

    // Subject of the email
    $subject = "Your Flight Ticket and User Details";

    // Message body
    $message = "Hello $name,\n\n";
    $message .= "Please find your flight ticket attached. Your email is: $email.";

    // File path to the flight ticket PDF
    $ticketFilePath = "/path/to/flight_ticket.pdf";

    // Boundary for multipart message
    $boundary = md5(uniqid(time()));

    // Headers
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message body
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . "\r\n";

    // Attach the flight ticket PDF
    $ticketContent = file_get_contents($ticketFilePath);
    $ticketBase64 = base64_encode($ticketContent);
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/pdf; name=\"flight_ticket.pdf\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"flight_ticket.pdf\"\r\n\r\n";
    $body .= chunk_split($ticketBase64) . "\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Email could not be sent.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Flight Ticket</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" value="Send Ticket">
    </form>
</body>
</html>

