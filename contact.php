<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function send_email($to, $subject, $message) {
    $api_key = $_ENV['MAILGUN_API_KEY'];
    $domain = $_ENV['MAILGUN_DOMAIN'];
    $from = 'info@jludance.org';
    $mg = Mailgun::create($api_key);

    $params = array(
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'text' => $message
    );

    $mg->messages()->send($domain, $params);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $message = $_POST["message"];

  // Sanitize inputs
  $name = trim(strip_tags($name));
  $email = trim(strip_tags($email));
  $phone = trim(strip_tags($phone));
  $message = trim(strip_tags($message));

  // Validate inputs
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email format";
      exit;
  }

  // Validate the phone number using a regular expression (optional)
  // if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
  //     echo "Invalid phone format";
  //     exit;
  // }

  // Send email or save to the database
  // ...
// Send email using Mailgun
  $to = 'admin@jludance.org';
  $subject = 'New Contact Form Submission';
  $message_body = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}";

  try {
      send_email($to, $subject, $message_body);
      echo "Thank you for contacting us! We'll get back to you soon.";
  } catch (Exception $e) {
      echo "Error sending email: " . $e->getMessage();
  }

}
?>
