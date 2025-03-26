<?php
/*
*   Project: LogDrive
*   Author: John Hart
*   Repo:  https://github.com/johnhart96/log-drive
*   Licence: GNU Public Licence
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if( ! file_exists( "data/config.php" ) ) {
  die( "Error: Unable to locate the config file!" );
} else {
  require_once 'data/config.php';
}
require_once 'inc/functions.php';
$db = dbc();
if( isset( $_POST['request'] ) ) {
  $request = filter_var( $_POST['request'] , FILTER_SANITIZE_NUMBER_INT );
  header( "Location: /request/" . $request );
}
require_once "vendor/autoload.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LogDrive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="<?php echo site_url( 'img/log-drive-logo.svg' ); ?>">
    <link href="<?php echo site_url( 'css/styles.css' ); ?>" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar bg-primary" data-bs-theme="dark">
      <div class="container">
        <a class="navbar-brand" href="/">
			<img src="<?php echo site_url( 'img/log-drive-logo.svg' ); ?>" alt="LogDrive" width="30" height="24">
			LogDrive
		</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
          </ul>
          <form class="d-flex" role="search" method="post">
            <input class="form-control me-2" autofocus type="search" name="request" placeholder="Request ID" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <div class="container my-5">
      <?php
      // Basic CMS
      if( ! empty( $_GET['id'] ) ) {
        define( "ID" , filter_var( $_GET['id'] , FILTER_UNSAFE_RAW ) );
      }
      if( ! empty( $_GET['page'] ) ) {
        define( "PAGE" , filter_var( $_GET['page'] , FILTER_UNSAFE_RAW ) );
        if( PAGE == "index.php" ) {
          require 'home.php';
        } else {
          $target_file = PAGE . ".php";
          if( file_exists( $target_file ) ) {
            require $target_file;
          } else {
            echo "<div class='alert alert-danger'><strong>Error:</strong> Cannot locate the desired page!</div>";
          }
        }
      }
      ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="main.js"></script>
  </body>
</html>