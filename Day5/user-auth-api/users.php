<?php

  function getUserByEmail($conn, $email){
      $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindParam(':email',$email);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  function getUserById($conn, $id){
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}



?>