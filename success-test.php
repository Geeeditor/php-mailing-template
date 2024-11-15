<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to autoload.php for PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nf-field-1'];
    $email = $_POST['email'];
    $message = $_POST['nf-field-3'];

    // Load the HTML email template
    $email_template = file_get_contents('template.html');

    // Replace placeholders in the template with actual data
    $email_template = str_replace('%name%', $name, $email_template);
    $email_template = str_replace('%message%', nl2br($message), $email_template);

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
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // You can also store the user's information in a database or perform other actions here
}
?>