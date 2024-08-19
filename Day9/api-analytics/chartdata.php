<?php
# DB Connection

$dsn = 'mysql:host=localhost;dbname=library';
$username = 'root';
$password = '';
$conn = new PDO($dsn,$username,$password);


# Fetch Data
$sql = "SELECT DATE(timestamp) as date,
               COUNT(*) as total_requests,
               AVG(response_time) as avg_response_time,
               SUM(CASE WHEN status_code >=400 THEN 1 ELSE 0 END) as total_errors
        
        FROM api_logs
        GROUP BY DATE(timestamp)
        ORDER BY DATE(timestamp)";

  $stmt = $conn->query($sql);
  $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

  # Prepare Chart Data
  $chartData = [
      'labels'=>[],
      'datasets'=>[
          [
            'label'=> 'Total Requests',
            'data'=>[],
            'borderColor' => 'rgba(75,192,192,1)',
            'borderWidth' =>2,

          ],
          [
            'label'=> 'Average Response Time',
            'data'=>[],
            'borderColor' => 'rgba(153,102,255,1)',
            'borderWidth' =>2,

          ],
          [
            'label'=> 'Total Errors',
            'data'=>[],
            'borderColor' => 'rgba(255,99,132,1)',
            'borderWidth' =>2,

          ],


      ]
        ];

    foreach($reportData as $row){
          $chartData['labels'][] = $row['date'];
          $chartData['datasets'][0]['data'][] = $row['total_requests'];
          $chartData['datasets'][1]['data'][] = $row['avg_response_time'];
          $chartData['datasets'][2]['data'][] = $row['total_errors'];

          
    }

    echo json_encode($chartData);


?>


