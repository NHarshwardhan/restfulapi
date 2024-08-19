<?php
require '../../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


$client = new Client(['base_uri'=>'http://localhost:8200/RESTFUL_API/Day8/Testing/']);

$token = null;
# Test successful Login

function testLoginSuccessful($client){
 global $token;
  $response = $client->post('api/login',[
       'json'=>[
           'username'=>'test',
           'password'=>'test123'
       ]
    ]);
   
    assertEquals(200,$response->getStatusCode(),"Expected status code 200");
    $data = json_decode($response->getBody(),true);
    assertArrayHasKey ('token',$data,"Expected token in response");
    $token = $data['token'];
}

# Test Login failure

function testLoginFailure($client){
    $response = $client->post('api/login',[
         'json'=>[
             'username'=>'test123123',
             'password'=>'test1231232eewe'
         ]
      ]);
     
      assertEquals(401,$response->getStatusCode(),"Expected status code 401");
   
  }


# Test accessing tasks without authentication
function testGetTasksWithoutAuthentication($client){
        
              $response = $client->get('api/tasks');   
     
              assertEquals(401,$response->getStatusCode(),"Expected status code 401");
          
}

# Test accessing tasks with authentication
function testGetTasksWithAuthentication($client){
    global $token;
        
    $response = $client->get('api/tasks',[
         'headers'=>['Authorization'=> 'Bearer '.$token]
    ]);   

    assertEquals(200,$response->getStatusCode(),"Expected status code 200");
    $data = json_decode($response->getBody(), true);
    assertIsArray($data, "Expected response to be an array");

}

# Test Creatimg a new task
function testCreateTask($client){
    global $token;
         
    $response = $client->post('api/tasks',[
        'headers'=>['Authorization'=> 'Bearer '.$token],
        'json'=>[
              "title"=>"New Task",
              "description"=>"Agenda: Project status"
        ]
   ]); 

   assertEquals(201,$response->getStatusCode(),"Expected status code 201");
   $data = json_decode($response->getBody(), true);
   assertEquals('New Task', $data['title'], "Expected title to be 'New Task'");
}

# TEST updating a task
function testUpdateTask($client){
    global $token;
         
    $response = $client->put('api/tasks/3',[
        'headers'=>['Authorization'=> 'Bearer '.$token],
        'json'=>[
              "title"=>"Updated New Title",             
        ]
   ]); 

   assertEquals(200,$response->getStatusCode(),"Expected status code 200");
   $data = json_decode($response->getBody(), true);
   assertEquals('Updated New Title', $data['title'], "Expected Updated New Title'");
}

# TEST Delete a task
function testDeleteTask($client){
    global $token;
         
    $response = $client->delete('api/tasks/3',[
        'headers'=>['Authorization'=> 'Bearer '.$token],
       
   ]); 

   assertEquals(204,$response->getStatusCode(),"Expected status code 204");
   #----Verify task is deleted--------------
   try{
    $client->get('api/tasks/3',[
        'headers'=>['Authorization'=> 'Bearer '.$token],
       
   ]); 
   }
   catch(RequestException $e){
       $response = $e->getResponse();
       assertEquals(404,$response->getStatusCode(),"Expected status code 404 after deletion");

   }
 
}


# Assertion Helpers

function assertEquals($expected, $acutal , $message=''){
        if($expected !== $acutal){
              echo "Assertion Failed..$message\n";
              echo "Expected: $expected\n";
              echo "Actual:  $acutal\n";
              exit(1);
        }

}
function assertArrayHasKey($key, $array , $message=''){
    if(!array_key_exists($key,$array)){
        echo "Assertion Failed..$message\n";
        echo "Expected Key: $key\n";     
        exit(1);
  }
}
function assertIsArray($value,  $message=''){
    if(!is_array($value)){
        echo "Assertion Failed..$message\n";
        echo "Expected: an Array\n";
        echo "Actual:".gettype($value)."\n";
        exit(1);
  }
}

# RUN TESTS
// testLoginSuccessful($client);
// testLoginFailure($client);
testGetTasksWithoutAuthentication($client);

// testGetTasksWithAuthentication($client);
// testCreateTask($client);
// testUpdateTask($client);
// testDeleteTask($client);




echo "All tests passed. \n";
?>