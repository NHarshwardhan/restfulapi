<?php
  
  //Helper function to parse JSON request bodies
    function getJsonInput(){
        return json_decode(file_get_contents('php://input'),true);
    }


   function getBookById($pdo, $bookId){
   
     $stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
     $stmt->bindParam(":id", $bookId, PDO::PARAM_INT);
     $stmt->execute();
     $book = $stmt->fetch(PDO::FETCH_ASSOC);
  
     if($book){
        header('Content-type: application/json');
        echo json_encode($book); 

     }else{
        http_response_code(404);
        echo json_encode(['message'=> 'Book Not Found']); 
     }


   }

   function getAllBooks($pdo){
    $stmt =  $pdo->query("SELECT * FROM books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-type: application/json');
    echo json_encode($books);

   }

   function addBook($pdo){
       $data =  getJsonInput();
       if(!empty($data['title']) && !empty($data['author'])){
          $stmt = $pdo->prepare("INSERT INTO books (title, author) VALUES(:title, :author)");
          $stmt->bindParam(':title', $data['title']);
          $stmt->bindParam(':author', $data['author']);
          $stmt->execute();

          http_response_code(201);
          echo json_encode(['message'=>'Book created successfully', 'book_id'=>$pdo->lastInsertId()]);
          
       }else{
        http_response_code(400);
        echo json_encode(['message'=>'Title and Author are required']);
       }

   }

?>