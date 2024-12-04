<?php
// Database connection parameters
$DB_HOST = 'dpg-ct2lk83qf0us739u2uvg-a.oregon-postgres.render.com';
$port = '5432';  // Default PostgreSQL port
$DB_NAME = 'opdmsis';
$DB_USER = 'opdmsis_user';
$DB_PASSWORD = '3sc6VNaexgXhje2UgoQ4fnvPf8x1KDGG';

// Create connection string
$conn_string = "host=$DB_HOST port=$port dbname=$DB_NAME user=$DB_USER password=$DB_PASSWORD";

// Establish connection
$con = pg_connect($conn_string);

// Check the connection
if (!$con) {
    die("Connection failed: " . pg_last_error());
}
?>
