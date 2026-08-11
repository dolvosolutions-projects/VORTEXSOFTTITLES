<?php
/**
 * VortexSoft Title Services LLC
 * Mail / SMTP Configuration using PHPMailer
 *
 * ⚠️  FILL IN YOUR HOSTINGER SMTP CREDENTIALS BELOW
 * Hostinger SMTP details: hPanel → Emails → Manage → Email Accounts
 */

define('SMTP_HOST',      'mail.vortexsofttitles.com'); // Hostinger mail server
define('SMTP_PORT',      465);                          // SSL=465, TLS=587
define('SMTP_USER',      'Contact@vortexsofttitles.com'); // Your email address
define('SMTP_PASS',      'CHANGE_ME_HOSTINGER_EMAIL_PASSWORD'); // ← Replace with email password
define('SMTP_FROM_NAME', 'VortexSoft Title Services');
define('SMTP_SECURE',    'ssl');   // 'ssl' for port 465, 'tls' for port 587

/**
 * Send email via PHPMailer
 *
 * @param string       $toEmail
 * @param string       $toName
 * @param string       $subject
 * @param string       $htmlBody
 * @param string|null  $replyTo
 * @return bool
 */
function sendMail(string $toEmail, string $toName, string $subject, string $htmlBody, ?string $replyTo = null): bool {
    // Use PHPMailer if available, fallback to php mail()
    $vendorMailer = ROOT_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    if (file_exists($vendorMailer)) {
        require_once $vendorMailer;
        require_once ROOT_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';
        require_once ROOT_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port       = SMTP_PORT;

            $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $toName);
            if ($replyTo) $mail->addReplyTo($replyTo);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody = strip_tags($htmlBody);

            return $mail->send();
        } catch (\Exception $e) {
            error_log('PHPMailer Error: ' . $e->getMessage());
            return false;
        }
    } else {
        // Fallback to native mail()
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . SMTP_FROM_NAME . " <" . SMTP_USER . ">\r\n";
        if ($replyTo) $headers .= "Reply-To: $replyTo\r\n";
        return mail($toEmail, $subject, $htmlBody, $headers);
    }
}
