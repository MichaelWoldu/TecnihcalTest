<?php

$csv = array_map('str_getcsv', file("data/interactions.csv")); // Loads CSV into memory as an array.

// Convert to a key => value Array.
array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
});

array_shift($csv); // Removes column headers.

// Removes unwanted Columns.
$csv = array_map(function($a){
    unset($a["date"]);
    unset($a["sector_id"]);
    return $a;
}, $csv);

$num = [];
// Convert into single array
foreach($csv as $row){
    $thestring = implode(", ", $row);
    $num[] = $thestring;
};
// Convert count into percentages
$newArr = array_count_values($num);
$total = array_sum($newArr);
$result = [];
foreach ($newArr as $row){
     $check = ($row / $total) * 100 ;
     $result [] =[$check];
};
// create array for data display
    $dataPoints = array( 
        array("label"=>"Materials", "y"=>$result[0]),
        array("label"=>"Real Estate", "y"=>$result[1]),
        array("label"=>"Energy", "y"=>$result[2]),
        array("label"=>"Communication Services", "y"=>$result[3]),
        array("label"=>"Healthcare", "y"=>$result[4]),
        array("label"=>"Information Technology", "y"=>$result[5]),
        array("label"=>"Consumer Staples", "y"=>$result[6]),
        array("label"=>"Financials", "y"=>$result[7]),
        array("label"=>"Utilities", "y"=>$result[9]),
        array("label"=>"Consumer Discretionary", "y"=>$result[10])
    )
?>
<!DOCTYPE HTML>
<html>
    <head>
        <script>
            window.onload = function() {
            
            
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Interaction between Client and Analyist"
                },
                subtitles: [{
                    text: "Techincal Test: Michael W. Hiluf"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
            
            }       
        </script>
    </head>
    <body>
        <div id="chartContainer" style="height: 500px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>             