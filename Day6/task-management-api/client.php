<?php
    
$baseurl = 'http://localhost:8200/RESTFUL_API/Day6/task-management-api/index.php';

function sendRequest($method, $uri, $data=null){
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if($data){
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
              curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        }

        $result = curl_exec($ch);

        curl_close($ch);
        return json_decode($result, true);

}

# Create Task

$taskId = null;
$createTaskUrl = $baseurl.'/task/create';
$newData = [
    'title'=>'Finish Project ',
    'description'=>'Complete API implemenation'
];
$response = sendRequest('POST',$createTaskUrl,$newData);
print_r($response);

$taskId = $response['id']?? null;

#1. Get Lists of tasks
   $getTasksUrl = $baseurl.'/tasks';
   $response = sendRequest('GET',$getTasksUrl,null);
   echo '<pre>';
//    print_r($response);

   //use the first task's link if available
   $firstTask = $response['tasks'][0] ?? null;
   if($firstTask){
       $taskLinks = $firstTask['links'] ??[];
   }


#2. Get Task Details (using HATEOAS links)
if(isset($taskLinks['self'])){
     $getTaskUrl = $baseurl.$taskLinks['self'];
    //  echo $getTaskUrl;
     $response = sendRequest('GET',$getTaskUrl,null);
     print_r($response);
}

  
#3. update Task

$updateurl  = $baseurl.$taskLinks['update'];
$updateData = [
    'title'=>'Finish Project v2',
    'description'=>'Refactor and optimize'
];
$response = sendRequest('PUT',$updateurl,$updateData);
print_r($response);



# 4. Delete task
$deleteUrl  = $baseurl.$taskLinks['delete'];
$response = sendRequest('DELETE',$deleteUrl,$updateData);
print_r($response);

?>