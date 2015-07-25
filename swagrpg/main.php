<?php

$MOBS = array(
  0 =>  array("name" => "Blue Slime"),
  1 =>  array("name" => "Green Slime"),
  2 =>  array("name" => "Ice Slime"),
  3 =>  array("name" => "Sand Slime"),
  4 =>  array("name" => "Lava Slime"),
  5 =>  array("name" => "Antlion"),
  6 =>  array("name" => "Antlion Charger"),
  7 =>  array("name" => "Antlion Swarmer"),
  8 =>  array("name" => "Vulture"),
  9 =>  array("name" => "Zombie"),
  10 => array("name" => "Zombie Eskimo"),
  11 => array("name" => "Demon Eye"),
  12 => array("name" => "Hellbat"),
  13 => array("name" => "Granite Elemental")
);

$BIOMES = array(
  "forest" => array(
    "lvl" => 0,
    "exp" => 5,
    "gold_min" => 35,
    "gold_max" => 150,
    "rest" => 45,
    "mobs"=> array(
      "day"   => array(0,1),
      "night" => array(9,11)
    )
  ),
  "tundra" => array(
    "lvl" => 4,
    "exp" => 7,
    "gold_min" => 50,
    "gold_max" => 160,
    "rest" => 60,
    "mobs"=> array(
      "day"   => array(2),
      "night" => array(10)
    )
  ),
  "desert" => array(
    "lvl" => 7,
    "exp" => 10,
    "gold_min" => 75,
    "gold_max" => 210,
    "rest" => 75,
    "mobs"=> array(
      "day"   => array(3,5,6,7,8),
      "night" => array(3,5,6,7,8)
    )
  ),
  "volcano" => array(
    "lvl" => 11,
    "exp" => 13,
    "gold_min" => 100,
    "gold_max" => 260,
    "rest" => 90,
    "mobs" => array(
      "day"   => array(4,12,13),
      "night" =>  array(4,12,13)
    )
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
if( isset($_STATE->{$sender}) ){
  $p = json_decode($_STATE->{$sender});
  if(isset($p->q) and ($p->q/1 != intval($p->q)) ){
    $p->q = floor($p->q);
    $_STATE->{$sender} = json_encode($p);
  }
}
/*
 * @param (Integer) $m - Money
 * @return (String) Formatted money value.
 */
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
 * @return (Integer) Current game time
 */
function game_time(){
  return array(
      "H" => sprintf('%.00F',(time()%1440)/60),
      "M" => sprintf('%.00F',time()%60),
      "F" => sprintf("%02d",(time()%1440)/60).":".sprintf("%02d",time()%60)
    );
}
/*
 * @param (Object)  $p - Player
 * @param (Integer) $e - Exp 
 * @param (String)  $m - Map
 * @param (Array)   $b - Biome
 * @param (Boolean) $n - Night
 * @return (Object) $p - Player with gained exp
 */
function gainExp($p,$m,$b,$e,$n){
  global $sender;
  global $MOBS;
  $p->q+=round($e*($n?2:1));
  $enm = $MOBS[$b['mobs'][$n?"night":"day"][array_rand($b['mobs'][$n?"night":"day"])]];
  $enm["name"] = (in_array($enm["name"][0],array('A','E','I','O','U'))?"an ":"a ").$enm["name"];
  $m = ucfirst($m);
  if($p->q >= $p->w){
    $p->q -= $p->w;
    $p->w=round($p->w*1.1);
    $p->l++;
    echo "$sender(Level: {$p->l}) has slain {$enm["name"]} in the $m! Exp gained: $e <|> Current exp: {$p->q} / {$p->w}";
    echo " <|> Congrulations, you've gained a level! <|> Current level: {$p->l}";
  } else {
    echo "$sender(Level: {$p->l}) has slain {$enm["name"]} in the $m! Exp gained: $e <|> Current exp: {$p->q} / {$p->w}";
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
  $time = game_time();
  if( floatval(str_replace(":",".",$time["F"])) > 19.3 or floatval(str_replace(":",".",$time["F"])) < 4.3 ){
    $is_night = true;
  }else{
    $is_night = false;
  }
  $cb = $BIOMES[$b];
  if($p->l >= $cb["lvl"]){
    $p = gainExp($p,$b,$cb,$cb["exp"],$is_night);
    $p->o = $cb["rest"];
    $mn = rand($cb["gold_min"],$cb["gold_max"]);
    $p->m += $mn*($is_night?2:1);
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
echo "swagRPG 0.0.49 <|> ";
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
        die("Biome doesn't exist! <|> You can go here instead: forest,desert or tundra");
      }
    }else {
      echo "Not so fast! You've got to wait before you can attack again!";
      die();
    }
    break;
  case "explore":
    die("You are not yet ready to explore!");
    break;
  case "notes":
    die("Coming soon: [mine] - you will be able to go mine various ores,stones - don't expect todo anything with them yet!");
    break;
  case "info":
    die("Current game time: ".game_time()["F"]);
    break;
  case "help":
    die('Use [pve <biome>] to fight mobs. Use [pve] to get biomes list. Use [me] to get information about yourself. Use [info] to get more info!');
    break;
  default:
    die('Invalid action! Use help to get more info!');
}
?>
