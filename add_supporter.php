<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'DBS.inc.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sup_email = trim($_POST['sup_email']);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT sup_email FROM supporters WHERE sup_email = ?");
    $stmt->execute([$sup_email]);
    if ($stmt->rowCount() > 0) {
        die("Error: This email is already registered as an advisor.");
    }

    // Generate a random password (8 characters)
    $raw_password = bin2hex(random_bytes(4)); // Example: "a3b9c8d2"

    // Insert into advisors table
    $stmt = $pdo->prepare("INSERT INTO supporters (sup_email, sup_password, password_updated) VALUES (?, ?, ?)");
    if ($stmt->execute([$sup_email, $raw_password, false])) {
        
        // Send Email Using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'guardsphere01@gmail.com'; // 🔴 Replace with your Gmail
            $mail->Password = 'qvhl kcbg xrph stff'; // 🔴 Replace with App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // 🔹 Fix SSL Error
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ),
            );

            // Email Details
            $mail->setFrom('guardsphere01@gmail.com', 'GuardSphere Admin');
            $mail->addAddress($sup_email);
            $mail->Subject = 'Your GuardSphere Advisor Account';
            $mail->Body = "Hello,\n\nAn admin has created your Supporter account.\n\nEmail: $sup_email\nPassword: $raw_password\n\nPlease log in and change your password.";

            if ($mail->send()) {
                echo "Supporter added successfully! Email sent.";
            } else {
                echo "Supporter added, but email sending failed.";
            }
        } catch (Exception $e) {
            echo "Supporter added, but email could not be sent. Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error adding Supporter.";
    }
}
?>

<form method="POST">
    <input type="email" name="sup_email" required placeholder="Enter Supporter Email">
    <button type="submit">Add Supporter</button>
</form>
