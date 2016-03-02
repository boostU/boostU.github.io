<?php

require_once "../vendor/autoload.php"; 
// check if fields passed are empty
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$name = htmlspecialchars($name);
$email_address = htmlspecialchars($email_address);
$phone = htmlspecialchars($phone);
$message = htmlspecialchars($message);

function sendgridEmail($name, $email_address, $phone, $message) {
    $name = htmlspecialchars($name);
    $email_address = htmlspecialchars($email_address);
    $phone = htmlspecialchars($phone);
    $message = htmlspecialchars($message);
    $html = "<p>Salut <strong>BoostU</strong>!</p>
            <p>Vous venez de recevoir un demande d'information:</p> <br>
            <p><strong>Nom:</strong> " .$name. "</p>
            <p><strong>Email:</strong> " .$email_address. "</p>
            <p><strong>Numéro de téléphone:</strong> " .$phone. "</p>
            <p><strong>Message:</strong><br>" .$message. "</p><br><br>
            <p style='color: grey;'>Bonne journée !</p>";

    $sendgrid = new SendGrid('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');
    $email = new SendGrid\Email();
    $email
        ->addSmtpapiTo('contact@boostucoaching.com')
        ->setFrom('contact@boostucoaching.com')
        ->setSubject('Contact information from landing page')
        ->setText('Salut BoostU')
        ->setHtml($html);

    // Or catch the error

    try {
        $sendgrid->send($email);
    } catch(\SendGrid\Exception $e) {
        echo $e->getCode();
        foreach($e->getErrors() as $er) {
            echo $er;
        }
    }
}

sendgridEmail($name, $email_address, $phone, $message);

?>
