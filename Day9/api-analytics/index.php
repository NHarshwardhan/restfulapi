<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>


</head>
<body>
       <h1>API ANALYTICS Dashboard</h1>
       <canvas id="myChart" width="600" height="400"></canvas>

       <script>
            let ctx = document.getElementById('myChart').getContext('2d');

            // Fetch chart data from server
            fetch("http://localhost:8200/RESTFUL_API/Day9/api-analytics/chartdata.php")
               .then(response=>response.json())
               .then(chartData=>{
                  
                new Chart(ctx,{
                       type:'line',
                       data: chartData,
                       options:{
                          responsive: true,
                          scales:{
                             x:{
                                type:'time',
                                time:{
                                    unit:'day'
                                },
                                title:{
                                     display: true,
                                     text: 'Date'
                                }
                             },
                             y:{
                                 beginAtZero: true,
                                 title:{
                                     display: true,
                                     text: 'Value'
                                 }
                             }
                          }
                       }
                })

               })
               .catch(error=> console.log(error))

           
       </script>
</body>
</html>