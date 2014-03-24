<?php
function getCurrentRooms() {
  $filter = (isset($_GET['filter'])) ? explode(",", $_GET['filter']) : '';
  
  if(isset($_GET['now'])) {
    $postdata = http_build_query(
      array(
        'filter' => $filter,
        'now' => 'CMON! GIMME DA ROOMZ!'
      )
    );
  }
  else if(!isset($_GET['begin']) || !isset($_GET['day']) || !isset($_GET['end'])) {
    echo '{error: "Missing parameters. Example: \'?now\' or \'?begin=8&end=9&day=jeudi&filter=CO,CE,CM\'"';
    exit;
  }
  else {
    $begin = $_GET['begin'];
    $day = $_GET['day'];
    $end = $_GET['end'];
    
    // 'now' => 'Find me a free room'
    $postdata = http_build_query(
      array(
        'begin' => $begin,
        'day' => $day,
        'end' => $end,
        'filter' => $filter,
        'normal' => 'Find me a free room'
      )
    );
  }  

  $opts = array('http' =>
    array(
      'method'  => 'POST',
      'header'  => 'Content-type: application/x-www-form-urlencoded',
      'content' => $postdata
    )
  );
  
  $context  = stream_context_create($opts);
  $result = file_get_contents('http://freeroom.foucqueteau.ch/results.php', false, $context);
  $result = str_replace(array("<em>", "</em>", "<strong>", "</strong>", "<br>", "<br/>", "<br />"), "", $result);

  return fetchData($result);
}

function fetchData($html) {
  libxml_use_internal_errors(true);
  $DOM = new DOMDocument;
  $DOM->loadHTML($html);
  $display = $DOM->getElementById('display');
  
  if($display == NULL) {
    return '{ "data": [] }';
  }
  
  $roomsArray = array();
  foreach($display->childNodes as $node) {
    $roomName = $node->nodeValue;
    
    if(!preg_match("/\s+/", $roomName) && $roomName != "") {
      array_push($roomsArray, '"'.$roomName.'"');
    }
  }
  
  $response = '{ "data": [' . implode(", ", $roomsArray) . '] }';
  
	return $response;
}

echo getCurrentRooms();
