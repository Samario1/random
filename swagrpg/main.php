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
  return $p;
}

$state = (array)$_STATE;
$player = isset($state[$sender])?json_decode($state[$sender],true):array();
$q = isset($arg[0])?$arg[0]:"";
$w = isset($arg[1])?$arg[1]:"";

if(count($player) < 4){
  isset($player[0]['j'])?$player[0]['j']=1:''; // joined
  isset($player[0]['l'])?$player[0]['l']=0:''; // level
  isset($player[0]['q'])?$player[0]['q']=0:''; // currentExp
  isset($player[0]['w'])?$player[0]['w']=10:''; // maxExp
}

if(!isset($q)){
  if(isset($state[$sender])){
    die($sender.' : Level: 0');
  }
  die('Welcome to swagRPG, use join to start playing!');
}
switch ($q){
  case "join":
    if(isset($state[$sender])){
      die('');
    }
    $_STATE->{$sender} = '[{"j":1,"l":0,"q":0,"w":10}]';
    die('Welcome to swagRPG - Maintained by swaganomic (https://github.com/MRokas), running on '.$bot);
    break;
  case "pvp":
    if(isset($w) && isset($_STATE->{$w}) ){
      die($sender.' has attacked '.$w);
    }else if(!isset($w)){
      die('You have to specify other player!');
    }else if(!isset($state[isset($w)])){
      die('Player does not exist');
    }
    break;
  case "pve":
    switch ($w) {
      case "forest":
        $player[0] = gainExp($player[0],9);
        die('You are in the forest');
        break;
      default:
        die('Biome does not exist!');
    }
    break;
  case "pve-debug":
    switch ($w) {
      case "forest":
        $player[0] = gainExp($player[0],9);
        print_r($player[0]);
        $_STATE->{$sender} = json_encode($player[0]);
        die('You are in the forest');
        break;
      default:
        die('Biome does not exist!');
    }
    break;
  case "me-debug":
    print_r($player);
    die('');
    break;
  case "me":
    die($sender.' |> Level:'.$player[0]["l"]);
    break;
  case "reset":
    unset($_STATE->{$sender});
    die('');
    break;
  default:
    die('');
}
?>
