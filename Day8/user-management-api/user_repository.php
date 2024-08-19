<?php
 require_once './data.php';
 
     function findUserById($id){
        global $users;
        return $users[$id] ?? null;
     }

     function insertUser($name){
        global $users;
        $id = count($users)+1;
        $users[$id] = ['id'=>$id, 'name'=>$name];
        return $users[$id];
     }

     function updateUserById($id, $name){
        global $users;
        if(isset($users[$id])){
            $users[$id]['name'] = $name;
            return $users[$id];
        }
        return null;
     }

     function deleteUserById($id){
        global $users;
        if(isset($users[$id])){
              unset($users[$id]);
              return true;
        }
        return false;
     }
?>