<?php

 require_once './user_repository.php';

 function getUserService($id){
    return findUserById($id);
 }
 function createUserService($name){
    return insertUser($name);
 }
 
 function updateUserService($id,$name){
    return updateUserById($id,$name);
 }
 
 function deleteUserService($id){
    return deleteUserById($id);
 }

?>