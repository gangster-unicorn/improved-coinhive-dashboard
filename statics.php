
<?php 
ini_set('display_errors', 0);
if ($_GET['key']) {
$key = $_GET['key'];
}



?>


<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Raleway:200" rel="stylesheet">
    <style>     
    body {
    background-color: #5b82c5;
}
        
    .hashes {
    font-family: 'Raleway', sans-serif;
    font-size: 8vw;
    color: rgb(161, 178, 208);
    margin-top: 2vw;
}
        
        
     .total {
    font-family: 'Raleway', sans-serif;
    font-size: 8vw;
    color: rgb(161, 178, 208);
    margin-top: -6vw;
}
        
        
   .xmr {
    font-family: 'Raleway', sans-serif;
    font-size: 8vw;
    color: rgb(161, 178, 208);
    margin-top: -6vw;
}
        
      .info {
    width: 75vw;
    margin-left: 13vw;
}
        
        #curve_chart {
    left: 0;
    position: absolute;
    width: 100%; 
    height: 40vw;
    
}
        
        
    #hashes {
    left: 0;
    position: absolute;
        margin-top: 40vw;
        height: 40vw;
        width: 100%;
    
}
        
        .gradient {
    width: 100%;
    height: 3%;
    position: absolute;
    margin-top: -1.5vw;
    left: 0;
    background: -webkit-linear-gradient(#5b82c5, white);
    background: -o-linear-gradient(#5b82c5, white);
    background: -moz-linear-gradient(#5b82c5, white);
    background: linear-gradient(#5b82c5, white);
}
</style>
</head>

   
    
<body>
  
    
    

<div class="info">
<?php
$json = file_get_contents('https://api.coinhive.com/stats/site?secret=' . $key . '&begin=1');
$json = json_decode($json, true);
$url = $json;
    
$len=count($url);
for ($i=0;$i<$len;$i++)
    
    
    if (strlen($url['xmrPending']) > 10)
   $url['xmrPending'] = substr($url['xmrPending'], 0, 7);    
    
  
echo ('<p class="hashes">' . $url['hashesPerSecond'] . ' HASHES/S</p>');

echo ('<p class="total">' . number_format($url['hashesTotal']) . ' TOTAL</p>');       

echo ('<p class="xmr">' . $url['xmrPending'] . ' XMR</p>');
    




?>
    
    
    
    
    
    
    
    <?php
$json = file_get_contents('https://api.coinhive.com/stats/history?secret=' . $key . '&begin=1');
$json = json_decode($json, true);
$url = $json['history'];
    
    
    
$json1 = file_get_contents('https://api.coinhive.com/stats/site?secret=' . $key . '&begin=1');
$json1 = json_decode($json1, true);
$url1 = $json1;  
   
$hashes = $url1['hashesTotal'];

$time=time();
       
$begin = $url[1]['time'];
    
$total = $time - $begin;
    
$avg = $hashes / $total;
    
if (strlen($avg) > 10)
$average = substr($avg, 0, 7);

echo ('<p class="xmr">' . $average . ' avrg h/s</p>');
?>
    
    
    
    
</div> 
  
    
    <div class="gradient"></div>
    
    
    
    <div id="curve_chart"></div>
    <div id="hashes"></div>
</body>
    

    
    
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tijd', 'Total hashes'],
                    <?php
$json = file_get_contents('https://api.coinhive.com/stats/history?secret=' . $key . '&begin=1');
$json = json_decode($json, true);
$url = $json['history'];


$len=count($url);
for ($i=0;$i<$len;$i++)
       
  

    
    
    echo ('[\'' . date("F j, Y, g:i a", $url[$i]['time']) . '\',        ' . $url[$i]['hashesTotal'] . '],
  ')        
          ?>

        ]);
    

        var options = {
          colors:['#ffc134'],
            title: 'Total hashes',
          curveType: 'function'

        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
</script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tijd', 'Hashes/s'],
                    <?php
$json = file_get_contents('https://api.coinhive.com/stats/history?secret=' . $key . '&begin=1');
$json = json_decode($json, true);
$url = $json['history'];


$len=count($url);
for ($i=0;$i<$len;$i++)
       
  echo ('[\'' . date("F j, Y, g:i a", $url[$i]['time']) . '\',' . $url[$i]['hashesPerSecond'] . '],
  ')        
          ?>

        ]);
    

        var options = {
          backgroundColor:'#ffffff',
            colors:['#26e0ae'],
          title: 'Hashes/s',
          curveType: 'function'

        };

        var chart = new google.visualization.LineChart(document.getElementById('hashes'));

        chart.draw(data, options);
      }
</script>   
</html>





