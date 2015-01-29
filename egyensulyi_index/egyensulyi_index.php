<?php
ini_set('display_errors', 1);
ini_set('default_charset', 'utf-8');

$numbers = array(-7,1,5,2,-4,3,0);

function e_index($numbers) {
  $indexList = array();
  foreach($numbers as $key => $val) {
    $sumPrev = null;
    $sumNext = null;
    //elem előtti összeg megállapítás
    for($i=0;$i<$key;$i++) {
      $sumPrev += $numbers[$i];
    }

    //elem uttáni összeg megállapítás
    for($i=$key + 1;$i<count($numbers);$i++) {
      $sumNext += $numbers[$i];
    }    

    if($sumPrev == $sumNext)
      array_push($indexList, $key);
  }

  if (count($indexList))
    return $indexList;
  else
    return -1;
}

$start = microtime(true);
$eIndex = e_index($numbers);
$time_elapsed_us = microtime(true) - $start;

if (is_array($eIndex))
  echo 'Egyensúlyi indexek: ' . implode(',', $eIndex);

?>