<?php

$_STATE = (array)$_STATE;
$player = isset($_STATE[$sender])?json_decode($_STATE[$sender],true):"";
$q = isset($arg[0])?$arg[0]:"";
$w = isset($arg[1])?$arg[1]:"";

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
    $_STATE[$sender] = '[{"j":true,"l":0}]';
    die('Welcome to TerrariaRPG - Maintained by swaganomic (https://github.com/MRokas), running on '.$bot);
    break;
  case "pvp":
    if(isset($w) && isset($_STATE[$w]) ){
      die($sender.' has attacked '.$w);
    }else if(!isset($w)){
      die('You have to specify other player!');
    }else if(!isset($_STATE[isset($w)])){
      die('Player does not exist');
    }
    break;
  case "pve":
    die('Monster have yet to start spawning!');
    switch($w){
      case "forest":
        die('You are in the forest');
        break;
    }
    break;
  case "me":
    die($sender.' |> Level:'.$player['l']);
  case "reset":
    unset($_STATE[$sender]);
  default:
    die('');
}

?>
