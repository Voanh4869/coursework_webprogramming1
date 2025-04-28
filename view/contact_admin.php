<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpmailer/vendor/autoload.php';
require __DIR__ . '/../includes/DatabaseConnection.php'; 

header('Content-Type: application/json'); 

$response = []; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        $response = ['success' => false, 'message' => 'All fields are required.'];
    } else {
        $adminEmail = 'anh862307@gmail.com'; 

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->Username = 'anhvo7923@gmail.com'; 
            $mail->Password = 'caarsyukvkoorntm'; 

            $mail->setFrom($email, $name); 
            $mail->addReplyTo($email, $name); 
            $mail->addAddress($adminEmail, 'Admin'); 
            $mail->Subject = 'You Have a New Message';
            $mail->Body = $message; 
           
            $mail->send();
            $response = ['success' => true, 'message' => 'Your message has been sent successfully.'];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Failed to send your message. Error: ' . $mail->ErrorInfo];
        }
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

echo json_encode($response);
exit();
?>