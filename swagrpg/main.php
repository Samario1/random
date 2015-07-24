<?php

// Check if user has all properies
if( isset($_STATE->{$sender}) and count((array)json_decode($_STATE->{$sender})) < 6){
  $p = json_decode($_STATE->{$sender});
  !isset($p->j)?$p->j=1:"";
  !isset($p->l)?$p->l=0:"";
  !isset($p->q)?$p->q=0:"";
  !isset($p->w)?$p->w=10:"";
  !isset($p->t)?$p->t=time()-45:"";
  !isset($p->o)?$p->o=45:"";
  
  $_STATE->{$sender} = json_encode($p);
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
  echo "$sender(Level: {$p->l})  slain {{enemy}} in the $m! Exp gained: $e <|> Current exp: {$p->q} / {$p->w}";
  if($p->q >= $p->w){
      $p->q -= $p->w;
      $p->w=round($p->w*1.1);
      $p->l++;
      echo " <|> Congrulations, you've gained a level! <|> Current level: {$p->l}";
    }
  $p->t=time();
  return $p;
}
/*
 * @param (Object)  $p - Player
 * @param (String)  $m - Map
 * @param (Integer) $c - Action cooldown 
 * @param (Integer) $e - Exp reward
 */
function action_pve($p,$m,$c,$e){
  global $sender;
  global $_STATE;
  $p = gainExp($p,$m,$e);
  $p->o = $c;
  $_STATE->{$sender} = json_encode($p);
}

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
// (t) => Timestamp of last action
// (o) => Action cooldown
echo "TEST 0.0.27 <|> ";
switch ($arg[0]){
  case "join":
    if(isset($_STATE->{$sender})){
      die("You've already joined the game - use reset, and then join to start a fresh game!");
    }
    $t = time()-45;
    $_STATE->{$sender} = "{\"j\":1,\"l\":0,\"q\":0,\"w\":10,\"t\":{$t},\"o\":45}";
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
    die($sender." <|> Current level: {$p->l} <|> Current exp: {$p->q} / {$p->w} <|> You'll be be able to attack in: {$t} seconds");
    break;
  case "pve":
    $p = json_decode($_STATE->{$sender});
    if((time()-$p->t) >= $p->o ){
      if(isset($arg[1])){
        switch($arg[1]){
          case "forest":
            action_pve($p,"forest",45,3);
            break;
          case "tundra":
            action_pve($p,"tundra",60,5);
            break;
        }
      } else {
        die("You've to specify biome! <|> Currently generated: forest, tundra");
      }
    }else {
      echo "Not so fast! You've to wait before you can attack again!";
      die();
    }
    break;
}
?>
