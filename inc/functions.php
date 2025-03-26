<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Site url
function site_url( $file ) {
    $protocol = isset($_SERVER['HTTPS']) && 
    $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

    return $base_url . "" . $file ;
}
// Init database
function dbc() {
    try {
        $db = new PDO( "mysql:host=" . DB_HOST . ":" . DB_PORT . ";dbname=" . DB_NAME , DB_USERNAME , DB_PASSWORD );
        return $db;
    } catch( PDOException $e ) {
        echo "Connection error ".$e->getMessage(); 
        return NULL;
        die();
    } 
}

// Status index
$status_list = array( 0 => "Awaiting upload" , 1 => "Received" );

// Init smtp
function init_smtp() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();   
    $mail->Host = SMTP_HOST;
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    if( ! empty( SMTP_USERNAME ) && ! empty( SMTP_PASSWORD ) ) {
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
    }
    switch( SMTP_SECURITY ) {
        case "STARTTLS":
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            break;
        case "SSL":
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            break;
    }
    $mail->Port = SMTP_PORT;
    $mail->setFrom( SMTP_FROM , 'LogDrive' );
    $mail->addAddress( SMTP_TO ); 
    $mail->isHTML(true);  
    return $mail;    
}
?>