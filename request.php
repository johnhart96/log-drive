<h1>Request <?php echo ID; ?></h1>
<?php
// Look up request
$request = $db->prepare( "SELECT * FROM `requests` WHERE `ticket` =:requestID LIMIT 1" );
$request->execute( [ ':requestID' => ID ] );
$count = 0;
while( $row = $request->fetch( PDO::FETCH_ASSOC ) ) {
    $count ++;
    $data = $row;
}
if( $count == 1 ) {
    $status_int = $data['status'];
    $status = $status_list[$status_int];
} else {
    echo "<div class='alert alert-danger'>Sorry, your request cannot be found. Please contact your support agent.</div>";
    die();
}
if( isset( $_POST['upload'] ) ) {
    $target_dir = "data/" . $data['ticket'] . "/";
    if( ! file_exists( $target_dir ) ) {
        mkdir( $target_dir );
    }
    $target_file = $target_dir . basename( $_FILES["fileToUpload"]["name"] );
    $uploadOk = 1;
    $fileType = strtolower( pathinfo( $target_file,PATHINFO_EXTENSION ) );
    // Check if file already exists
    if( file_exists( $target_file ) ) {
        echo "<div class='alert alert-danger'>Sorry, file already exists.</div>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if( $fileType != "zip" ) {
        echo "<div class='alert alert-danger'>Sorry, only ZIP files are allowed.</div>";
        $uploadOk = 0;
    }
    if ( $uploadOk == 0 ) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"] , $target_file ) ) {
            $update = $db->prepare( "UPDATE `requests` SET `status` =1 WHERE `ticket` =:ticketID LIMIT 1" );
            $update->execute( [ ':ticketID' => ID ] );
            $mail = init_smtp();
            $mail->Subject = "[ Ticket: " . ID . " ] Logs received";
            $mail->Body = "
                <p>
                    You have received log files on this ticket. <br />
                    Please download the logs from <a href='" . site_url( $target_file ) . "'>here</a> <br />
                    <br />
                    <em>Files uploaded via LogDrive</em>
                </p>
            ";
            $mail->send();
            echo "<div class='alert alert-success'>The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"] ) ) . " has been uploaded.</div>";
        }
    }
}
?>
<div class="col-lg-8 px-0">
    <p class="fs-5">
        Status: <?php echo $status; ?>
    </p>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Please select a zip file:</label>
            <input type="file" name="fileToUpload" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" name="upload" class="btn btn-success">Upload</button>
        </div>
    </form>
    <p>Files:</p>
    <table class="table table-bordered table-stripped">
        <?php
        $target_dir = "data/" . $data['ticket'] . "/";
        if( ! file_exists( $target_dir ) ) {
            mkdir( $target_dir );
        }
        $files = scandir( $target_dir );
        unset( $files[0] );
        unset( $files[1] );
        foreach( $files as $file ) {
            $fileType = strtolower( pathinfo( $file , PATHINFO_EXTENSION ) );
            echo "<tr>";
            echo "<td width='1'>";
            echo "<img src='" . site_url( "img/" . $fileType . ".png" ) . "' height='24' width='24'>";
            echo "</td>";
            echo "<td><a href='" . site_url( "data/" . ID . "/" . $file ) . "'>";
            echo $file;
            echo "</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>