<?php

// Check if user has all properies
if( isset($_STATE->{$sender}) and count((array)json_decode($_STATE->{$sender})) < 5){
  $p = json_decode($_STATE->{$sender});
  !isset($p->j)?$p->j=1:"";
  !isset($p->l)?$p->l=0:"";
  !isset($p->q)?$p->q=0:"";
  !isset($p->w)?$p->w=10:"";
  !isset($p->t)?$p->t=time()-60:"";
  
  $_STATE->{$sender} = json_encode($p);
}

function gainExp($p,$e){
  global $sender;
  $p->q+=$e;
  echo "$sender(Level: {$p->l})  slain blue slime in the forest! Exp gained: $e <|> Current exp: {$p->q} / {$p->w}";
  if($p->q >= $p->w){
      $p->q -= $p->w;
      $p->w=round($p->w*1.1);
      $p->l++;
      echo " <|> Congrulations, you've gained a level! <|> Current level: {$p->l}";
    }
  $p->t=time();
  return $p;
}

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
echo "TEST 0.0.24 <|> ";
switch ($arg[0]){
  case "join":
    if(isset($_STATE->{$sender})){
      die("You've already joined the game - use reset, and then join to start a fresh game!");
    }
    $t = time()-60;
    $_STATE->{$sender} = "{\"j\":1,\"l\":0,\"q\":0,\"w\":10,\"t\":{$t}}";
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
    $t = 60-(time()-$p->t)>0?60-(time()-$p->t):0;
    die($sender." <|> Current level: {$p->l} <|> Current exp: {$p->q} / {$p->w} <|> You'll be be able to attack in: {$t} seconds");
    break;
  case "pve":
    $p = json_decode($_STATE->{$sender});
    if((time()-$p->t) >= 60 ){
      $p = gainExp($p,7);
      $_STATE->{$sender} = json_encode($p);
    }else {
      echo "Not so fast! You've to wait before you can attack again!";
      die();
    }
    break;
}
?>
