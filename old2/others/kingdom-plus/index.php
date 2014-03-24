<?php

$filename = "kingdom-db";

if(isset($_GET['inc'])) {
  if(file_put_contents($filename, time()."\n", FILE_APPEND)) {
    echo "success";
  }
  else {
    echo "error";
  }
}
else {
  if(file_exists($filename) && ($data = file_get_contents($filename)) !== false) {
    $data = split("\n", $data);
    array_pop($data);

    for($i = 0; $i < sizeof($data); $i++) {
      // DAY
      $round = 60*60*24;
      $data[$i] = intval(floor($data[$i]/$round)*$round);
    }

    $data = array_count_values($data);
    
    $jsdata = "";
    
    foreach($data as $key => $value) {
      $jsdata .= "[".($key*1000).", ".$value."], ";
    }
?>
<h1>Usage per day of Kingdom+</h1>
<div id="placeholder" style="width:800px;height:600px"></div>
<script src="jquery.js"></script>
<script src="jquery.flot.js"></script>
<script src="jquery.flot.time.js"></script>
<script>
var data = [[<?php echo $jsdata; ?>]]
$.plot($("#placeholder"), data,
{
  series: {
    lines: {
      show: true,
    },
    points: {
      show: true
    },
    color: "#1E90FF"
  },
  
  yaxis: { min: 0 },
  xaxis: { mode: "time", timeformat: "%d.%m.%y", minTickSize: [1, "day"] },
});

console.log(data)

</script>

<?php
  }
  else {
    echo "error";
  }
}
