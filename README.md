# LogDrive
LogDrive is a simple web application to upload log files in order to get them sent over via email.

## Install
* Requires Apache HTTPD to function, but if you can write your own rewrite rules for nginx it will work fine.
* Requires PHP 8.0 or later
* MariaDB Server for DB.

1) Install the files into your web root.
2) Create the *data/* directory.
3) Make sure that the www-data user has write access .
4) Create your database using the SQL in *db.sql*.
5) Run ```composer install``` in your web root directory.
6) Create *data/config.php* as per the *sample.config*
