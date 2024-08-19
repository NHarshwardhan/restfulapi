<?php
 
  require './logger.php';

  $log = getLogger();

  # Example data store (in-memory array)

   $tasks = [
      1 => ['id'=>1, 'title'=>'Task 1', 'completed'=> false],
      2 => ['id'=>2, 'title'=>'Task 2', 'completed'=> false],
   ];

   # Handle the incoming request

   $requestMethod = $_SERVER['REQUEST_METHOD'];

   $fullUrl = $_SERVER['REQUEST_URI'];
   $parsedUrl = parse_url($fullUrl);
   $path = $parsedUrl['path'];

   $pathComponents = explode('/',$path);
   $apiIndex = array_search('api',$pathComponents);
   $path = implode('/',array_slice($pathComponents, $apiIndex));


   # Track start time
   $startTime = microtime(true);
   $responseTime = null;
   $latencyStart = microtime(true);
  
   try{
            if($path === 'api/tasks' && $requestMethod === 'GET'){
                 # List all tasks
                 $response = $tasks;
                 $latency = microtime(true) - $latencyStart;
                 header('Content-Type: application/json');
                 echo json_encode($response);
            }
            elseif(preg_match('/api\/tasks\/(\d+)/',$path,$matches) && $requestMethod === 'GET'){
                 $taskId = $matches[1];
                 if(isset($tasks[$taskId])){
                     $response = $tasks[$taskId];
                     $latency = microtime(true) - $latencyStart;
                     header('Content-Type: application/json');
                     echo json_encode($response);
                 }else{
                    throw new Exception('Task not found',400);
                 }
            }
            elseif($path === 'api/tasks' && $requestMethod === 'POST'){
                 $input = json_decode(file_get_contents('php://input'),true);
                 $newTaskid = count($tasks)+1;
                 $tasks[$newTaskid] = ['id'=>$newTaskid, 'title'=>$input['title'],'completed'=>false];
                 $response = $tasks[$newTaskid];
                 $latency = microtime(true) - $latencyStart;
                 header('Content-Type: application/json');
                echo json_encode($response);
            }else{
                 throw new Exception('Endpoint not found',404);
            }

            # Mesasure and log response time and latency

            $responseTime = microtime(true) - $startTime;
            $log->info('Performance Metrics',[
                  'path'=>$path,
                  'method'=>$requestMethod,
                  'response_time_ms' => round($responseTime * 1000 ,2),
                  'latency_ms'=> round($latency * 1000 , 2)
            ]);
   }
   catch(Exception $e){
         # Handle and log errors
         $responseTime = microtime(true)  - $startTime;
         $log->error('Exception occurred',[
             'message'=> $e->getMessage(),
             'code'=>$e->getCode(),
             'response_time_ms'=> round($responseTime * 1000 ,2),
         ]);
         http_response_code($e->getCode()?:500);
         echo json_encode(['error'=>$e->getMessage()]);
   }


   # calculate throughput (requests per second)
   if($responseTime > 0){
      $throughput = 1 / $responseTime;
      $log->info('Throughput',[
          'thorughput_rps' => round($throughput, 2)
      ]);
   }

?>