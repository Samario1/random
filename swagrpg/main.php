<?php

$_STATE = (array)$_STATE;
$q = $arg[0];
$w = $arg[1];

if(!isset($q)){
  if(isset($_STATE[$sender])){
    die($sender.' : Level: 0');
  }
  die('Welcome to swagRPG, use join to start playing!');
}
switch ($q){
  case "join":
    if(isset($_STATE[$sender])){
      die('');
    }
    $_STATE[$sender] = array();
    $_STATE[$sender]['status'] = 'Joined';
    break;
  case "pvp":
    if(isset($w) && isset($_STATE[$w]) ){
      die($sender.' has attacked '.$w;
    }else if(!isset($w)){
      die('You have to specify other player!');
    }else if(!isset($_STATE[isset($w)])){
      die('Player does not exist');
    }
    break;
  default:
    die('');
}

?>
