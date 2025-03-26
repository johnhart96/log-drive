<?php
/*
*   Project: LogDrive
*   Author: John Hart
*   Repo:  https://github.com/johnhart96/log-drive
*   Licence: GNU Public Licence
*/
?>
<h1>Create log request</h1>
<?php
if( isset( $_POST['submit'] ) ) {
    $ticket = filter_var( $_POST['ticket'] , FILTER_UNSAFE_RAW );
    $create = $db->prepare( "INSERT INTO `requests` (`ticket`) VALUES(:ticketID)" );
    $create->execute( [ ':ticketID' => $ticket ] );

    // Check it was created
    $count = 0;
    $check = $db->prepare( "SELECT * FROM `requests` WHERE `ticket` =:ticketID" );
    $check->execute( [ ':ticketID' => $ticket ] );
    while( $row = $check->fetch( PDO::FETCH_ASSOC ) ) {
        $count ++;
    }
    if( $count == 1 ) {
        echo "<div class='alert alert-success'>Request created. Your link is <pre>" . site_url( "request/" . $ticket ) . "</pre></div>";
    } else {
        echo "<div class='alert alert-danger'>An error occured!</div>";
        die();
    }
}
?>
<div class="col-lg-8 px-0">
    <form method="post">
        <div class="form-group">
            <label for="ticket">Ticket ID:</label>
            <input class="form-control" type="text" name="ticket" autofocus required>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-success">Create</button>
        </div>
    </form>
</div>