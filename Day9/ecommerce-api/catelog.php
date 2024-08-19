<!-- Product Catalog API -->
<?php
  header('Content-Type: application/json');

  # Simulate product data
  $products = [
     ["id"=>1, "name"=>"Laptop", "price"=>1200],
     ["id"=>2, "name"=>"Smartphone", "price"=>800],
     ["id"=>3, "name"=>"Headphones", "price"=>150],
  ];


  // simulate delay
  usleep(50000); # 50ms delay

  echo json_encode($products);


?>