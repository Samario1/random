<?php

$_STATE = (array)$_STATE;
if((array)$_STATE[$sender]){$player = (array)$_STATE[$sender]}
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
    $_STATE[$sender] = array();
    $_STATE[$sender]['s'] = 'Joined';
    $_STATE[$sender]['l'] = 0;
    die('Welcome to swagRPG - soon to be moved to #<TBD> ');
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
    break;
  case "me":
    die($sender.' |> Level:'.$player['l']);
  case "reset":
    unset($_STATE[$sender]);
  default:
    die('');
}

?>
