<?php

function gainExp($p,$e){
  global $sender;
  echo "$sender slain blue slime in the forest! Exp gained: $e";
  $p->q+=$e;
  if($p->q >= $p->w){
      $p->q -= $p->w;
      $p->w=round($p->w*1.1);
      $p->l++;
      echo " | Congrulations, you've gained a level!";
    }
  return $p;
}

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
echo "TEST 0.0.13 <|> ";
switch ($arg[0]){
  case "join":
    if(isset($_STATE->{$sender})){
      die("You've already joined the game - use reset, and then join to start a fresh game!");
    }
    $_STATE->{$sender} = "{\"j\":1,\"l\":0,\"q\":0,\"w\":10}";
    break;
  case "reset":
    $_STATE->{$sender} = "";
    unset($_STATE->{$sender});
    break;
  case "me":
    print_r($_STATE->{$sender});
    break;
  case "pve":
    $p = gainExp(json_decode($_STATE->{$sender}),7);
    $_STATE->{$sender} = json_encode($p);
    break;
}
?>
