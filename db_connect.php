<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=korealicious';
$username = 'root'; 
$password = ''; 


try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>Error: $error_message</p>";
    exit();
}
?>
