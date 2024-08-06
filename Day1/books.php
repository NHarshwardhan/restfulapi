<?php
require_once 'db.php';
require_once 'functions.php';


//Handle different HTTP Methods
$requestMethod = $_SERVER['REQUEST_METHOD'];
$bookId = isset($_GET['id'])? intval($_GET['id']):null;


switch($requestMethod){
        case 'GET':
             if($bookId){
                 getBookById($pdo,$bookId);
             }else{
                  getAllBooks($pdo);
             }
          break;

        case 'POST':
             addBook($pdo);
             break;

        default:
            http_response_code(405);
            echo json_encode(['message'=>'Method Not Allowed']);
            break;
}

?>