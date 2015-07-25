<?php

$BIOMES = array(
  "forest" => array(
      "lvl" => 0,
      "exp" => 5,
      "gold_min" => 35,
      "gold_max" => 150,
      "rest" => 45
    ),
  "desert" => array(
      "lvl" => 4,
      "exp" => 7,
      "gold_min" => 50,
      "gold_max" => 160,
      "rest" => 60
    ),
  "tundra" => array(
      "lvl" => 7,
      "exp" => 10,
      "gold_min" => 75,
      "gold_max" => 210,
      "rest" => 65
    )
  );

// if no arg
if(!isset($arg[0])){
  die('No action specified - use help to get more info!');
}

// Check if user has all properies
if( isset($_STATE->{$sender}) and count((array)json_decode($_STATE->{$sender})) < 7){
  $p = json_decode($_STATE->{$sender});
  !isset($p->j)?$p->j=1:"";
  !isset($p->l)?$p->l=0:"";
  !isset($p->q)?$p->q=0:"";
  !isset($p->w)?$p->w=10:"";
  !isset($p->t)?$p->t=time()-45:"";
  !isset($p->o)?$p->o=45:"";
  !isset($p->m)?$p->m=0:"";
  
  $_STATE->{$sender} = json_encode($p);
}
function money_parse($m){
  $c =  $m%100;
  $m -= $c;
  $s =  floor($m/100)%100;
  $m -= $s*100;
  $g =  floor($m/10000)%100;
  $m -= $g*10000;
  $p =  floor($m/1000000)%100;

  return ($p>0?$p+" Plat. ":"").($g>0?$g." Gold ":"").($s>0?$s." Silver ":"").$c." Copper";
}
/*
 * @param (Object)  $p - Player
 * @param (Integer) $e - Exp 
 * @param (String)  $m - Map
 * @return (Object) $p - Player with gained exp
 */
function gainExp($p,$m,$e){
  global $sender;
  $p->q+=$e;
  if($p->q >= $p->w){
    $p->q -= $p->w;
    $p->w=round($p->w*1.1);
    $p->l++;
    echo "$sender(Level: {$p->l})  slain {{enemy}} in the $m! Exp gained: $e <|> Current exp: {$p->q} / {$p->w}";
    echo " <|> Congrulations, you've gained a level! <|> Current level: {$p->l}";
  } else {
    echo "$sender(Level: {$p->l})  slain {{enemy}} in the $m! Exp gained: $e <|> Current exp: {$p->q} / {$p->w}";
  }
    
  $p->t=time();
  return $p;
}
/*
 * @param (Object)  $p - Player
 * @param (Array)   $b - Biome
 */
 function action_pve($p,$b){
  global $sender;
  global $_STATE;
  global $BIOMES;
  $cb = $BIOMES[$b];
  if($p->l >= $cb["lvl"]){
    $p = gainExp($p,$b,$cb["exp"]);
    $p->o = $cb["rest"];
    $mn = rand($cb["gold_min"],$cb["gold_max"]);
    $p->m += $mn;
    echo(" <|> Money gained: ".money_parse($mn)." <|> Current ammount: ".money_parse($p->m)); // TODO: Make money parse into NpNgNsNc format.
    $_STATE->{$sender} = json_encode($p);
  }else{
    $c=$cb["rest"]*2;
    $p->t = time();
    $p->o = $c;
    $_STATE->{$sender} = json_encode($p);
    die("You've failed to farm at $b. You will be able to attack in $c seconds.");
  }
}

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
// (t) => Timestamp of last action
// (o) => Action cooldown
// (m) => Money
echo "tRPG 0.0.40 <|> ";
switch ($arg[0]){
  case "join":
    if(isset($_STATE->{$sender})){
      die("You've already joined the game - use reset, and then join to start a fresh game!");
    }
    $t = time()-45;
    $_STATE->{$sender} = "{\"j\":1,\"l\":0,\"q\":0,\"w\":10,\"t\":{$t},\"o\":45,\"m\":0}";
    die("Welcome to tRPG!");
    break;
  case "reset":
    $_STATE->{$sender} = "";
    unset($_STATE->{$sender});
    die("Your character has been deleted");
    break;
  case "debugme":
    echo "Length: ".count((array)json_decode($_STATE->{$sender}))."<|>";
    print_r(json_decode($_STATE->{$sender}));
    break;
  case "me":
    $p = json_decode($_STATE->{$sender});
    $t = $p->o-(time()-$p->t)>0?$p->o-(time()-$p->t):0;
    die($sender." <|> Current level: {$p->l} <|> Current exp: {$p->q} / {$p->w} <|> Current money: ".money_parse($p->m)." <|> You'll be be able to attack in: {$t} seconds");
    break;
  case "pve":
    $p = json_decode($_STATE->{$sender});
    if((time()-$p->t) >= $p->o ){
      if(isset($arg[1]) and array_key_exists($arg[1], $BIOMES)){
        action_pve($p,$arg[1]);
        break;
      } else {
        die("Biome does't exist! <|> You can go here instead: forest,desert or tundra");
      }
    }else {
      echo "Not so fast! You've to wait before you can attack again!";
      die();
    }
    break;
  case "info":
    die("Coming soon: [mine] - you will be able to go mine various ores,stones - don't expect todo anything with them yet!");
    break;
  case "help":
    die('Use [pve <biome>] to fight mobs. Use [pve] to get biomes list. Use [me] to get information about yourself. Use [info] to get more info!');
    break;
  default:
    die('Invalid action! Use help to get more info!');
}
?>
