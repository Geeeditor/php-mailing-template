<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to autoload.php for PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nf-field-1'];
    $email = $_POST['email'];
    $message = nl2br($_POST['nf-field-3']); // Apply nl2br function to preserve line breaks

    // Email template
    $email_template = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Email Confirmation</title>
    </head>
    <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>
            <h2 style='color: #333;'>Hello $name,</h2>
            <p>Thank you for submitting your email. We have received the following message:</p>
            <p>$message</p>
            <p>Our team will be in touch shortly.</p>
            <p style='margin-top: 20px; font-style: italic;'>Best regards,<br>Oil Refinery Limited Liability</p>
        </div>
    </body>
    </html>";

    // PHPMailer configuration
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'b3b72301f93fa3'; // Your SMTP username
        $mail->Password = 'cb690bfe5dedab'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Your SMTP port

        $mail->setFrom('your@example.com', 'Your Name');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Thank you for your submission';
        $mail->Body = $email_template;

        $mail->send();
        header("Location: confirmation.html");
die();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // You can also store the user's information in a database or perform other actions here
}
?>