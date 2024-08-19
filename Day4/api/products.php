<?php
  header('Content-type:application/json');

  # DB Connection
  try{
       $pdo = new PDO('mysql:host=localhost;dbname=library','root','');

  }
  catch(PDOException $e){
      echo json_encode(
        ['error'=>'Database connection failed'.$e->getMessage()]
      );
  }

  # Pagination Parameters
  $page = isset($_GET['page'])?intval($_GET['page']):1;
  $limit = isset($_GET['limit'])?intval($_GET['limit']):10;
  $offset = ($page-1) * $limit;

  #Filtering Parameter
    $category = isset($_GET['category'])?$_GET['category']:'';
    $min_price = isset($_GET['min_price'])? floatval($_GET['min_price']):0;
    $max_price = isset($_GET['max_price'])? floatval($_GET['max_price']):PHP_INT_MAX;
    
   
  # Sql query with filtering , LIMIT, and Offset
  $sql = "SELECT * FROM products
          WHERE category LIKE :category
          AND price BETWEEN :min_price AND :max_price
          ORDER BY created_at DESC
          LIMIT :limit OFFSET :offset
         ";


   $stmt = $pdo->prepare($sql);
   $stmt->bindValue(":category","%". $category. "%", PDO::PARAM_STR);
   $stmt->bindValue(":min_price",$min_price, PDO::PARAM_STR);
   $stmt->bindValue(":max_price",$max_price, PDO::PARAM_STR);
   $stmt->bindValue(":limit",$limit, PDO::PARAM_INT);
   $stmt->bindValue(":offset",$offset, PDO::PARAM_INT);
   $stmt->execute();

//    print_r($stmt);

   # Fetch Results
   $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

   # Return results as JSON
   echo json_encode($products);



?>