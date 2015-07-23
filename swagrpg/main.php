<?php

include 'actions.php';

$_STATE = (array)$_STATE;
$player = isset($_STATE[$sender])?json_decode($_STATE[$sender],true):array();
$q = isset($arg[0])?$arg[0]:"";
$w = isset($arg[1])?$arg[1]:"";

if(count($player) < 2){
  isset($player['j'])?$player['j']=1:''; // joined
  isset($player['l'])?$player['l']=0:''; // level
  isset($player['q'])?$player['q']=0:''; // currentExp
  isset($player['w'])?$player['w']=10:''; // maxExp

}

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
    $_STATE[$sender] = '[{"j":1,"l":0,"q":0,"w":10}]';
    die('Welcome to swagRPG - Maintained by swaganomic (https://github.com/MRokas), running on '.$bot);
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
    switch ($w) {
      case "forest":
        gainExp($player,1);
        die('You are in the forest');
        break;
      default:
        die('Biome does not exist!');
    }
    break;
  case "me-debug":
    print_r($player);
    break;
  case "me":
    die($sender.' |> Level:'.$player[0]["l"]);
    break;
  case "reset":
    unset($_STATE[$sender]);
    break;
  default:
    die('');
}

?>
