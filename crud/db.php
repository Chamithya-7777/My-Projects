<?php
// db.php
ini_set('display_errors',1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university";   // <- make sure this matches your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// whitelist mapping: URL type -> actual table name
function get_table($type) {
    $map = [
        'student'  => 'students',
        'lecturer' => 'lecturers',
        'course'   => 'courses'
    ];
    return $map[$type] ?? false;
}
?>
