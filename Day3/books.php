<?php

 require_once 'config.php';

 header('Content-Type: application/json');

 $method = $_SERVER['REQUEST_METHOD'];

 $request = explode('/',trim(isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'','/'));
 
 $id = isset($request[0]) ? intval($request[0]): 0;

 switch($method){
        case 'GET':
           if($id){
               $sql = "SELECT * FROM books WHERE id = ? ";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("i",$id);
               $stmt->execute();
               $result = $stmt->get_result();
               $book = $result->fetch_assoc();
               echo json_encode($book);
               $stmt->close();
           }else{
                $sql = "SELECT * FROM books";
                $result = $conn->query($sql);
                $books = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($books);
           }
           break;

        case 'POST':
             $data = json_decode(file_get_contents('php://input'),true);
             $sql = "INSERT INTO books(title, author)VALUES(?,?)";
             $stmt = $conn->prepare($sql);
             $stmt->bind_param('ss',$data['title'],$data['author']);
             $stmt->execute();
             echo json_encode(['id'=>$stmt->insert_id]);
             $stmt->close();
             break;
        case 'PUT':
             $data = json_decode(file_get_contents('php://input'),true);
             $sql = "UPDATE books SET title=? , author=? WHERE id = ?";
             $stmt = $conn->prepare($sql);
             $stmt->bind_param('ssi',$data['title'],$data['author'],$id);
             $stmt->execute();
             echo json_encode(['message'=>'Record updated successfully']);
             $stmt->close();
             break;
        case 'DELETE':
             $sql = "DELETE FROM books WHERE id = ?";
             $stmt = $conn->prepare($sql);
             $stmt->bind_param('i',$id);
             $stmt->execute();
             echo json_encode(['message'=>'Record deleted successfully']);
             $stmt->close();
             break;

        default:
             http_response_code(405);
             echo json_encode(['message'=>'Method not allowed']);
             break;
        
 } 

 $conn->close();


?>