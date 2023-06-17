<?php


function sendEmail($to, $name)
{

    // SMTP configuration
ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', 587);
ini_set('sendmail_from', 'leon00albert@gmail.com');
ini_set('sendmail_path', '"/usr/sbin/sendmail -t -i"'); // This path may vary depending on your server configuration

// Email headers
$headers = 'From: Your Name <your_email@gmail.com>' . "\r\n";
$headers .= 'Reply-To: your_email@gmail.com' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();



// Email subject and message
$subject = 'Test Email';
$message = 'hello ' . $name  . ' This is a test email sent from PHP using the mail() function.';

// Send the email
$mailSent = mail($to, $subject, $message, $headers);

// Check if the email was sent successfully
if ($mailSent) {
    echo 'Email sent successfully.';
} else {
    echo 'Failed to send email.';
}

}
