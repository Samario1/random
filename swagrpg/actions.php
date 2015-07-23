<?php

function gainExp($p,$e){
  $p['q']+=$e;
  echo 'You have gained '.$e.' experience!';
  if($p['q']>=$p['w']){
    $p['q']-=$p['w'];
    $p['l']++;
    $p['w']*=1.1;
    echo 'You have gained a level!';
  }
  die('');
}

?>
