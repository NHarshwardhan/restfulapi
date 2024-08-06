<?php
//   $url = "http://localhost:8200/RESTFUL_API/Day2/UrlsDemo.php?id=123&sort=asc";
  
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443)? "https://":"http://";
  $host = $_SERVER['HTTP_HOST'];
  $uri = $_SERVER['REQUEST_URI'];

  $url = $protocol.$host.$uri;


  //Parse the url
  $parsedUrl = parse_url($url);


  echo 'Scheme = '.$parsedUrl['scheme'].'<br>';
  echo 'Host = '.$parsedUrl['host'].'<br>';
  echo 'port = '.$parsedUrl['port'].'<br>';
  echo 'path = '.$parsedUrl['path'].'<br>';
//   echo 'Query = '.$parsedUrl['query'].'<br>';


 //Parse the query string into an assocaiattive array
//   parse_str($parsedUrl['query'],$queryParams);
  
//   echo "Id = ".$queryParams['id']. '<br/>';
//   echo 'sort = '.$queryParams['sort']."<br/>";
 

 // Dynamically construct url
 
//    $scheme = "https";
//    $host = "www.example.com";
//    $path = "/search";
//    $queryParams = [
//       'query'=>'php', 'sort' =>'asc'
//    ];

//    $url = $scheme. "://".$host.$path."?".http_build_query($queryParams);

//     echo 'Constructed URL :'.$url;

?>