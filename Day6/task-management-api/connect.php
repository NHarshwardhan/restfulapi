<?php



$host = "localhost";
$db_name = 'library';
$username = 'root';
$password = '';


try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    return $conn;
} catch (PDOException $e) {
}
