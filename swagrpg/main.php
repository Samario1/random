<?php

function gainExp($p,$e){
  echo "$sender slain blue slime in the forest! Exp gained: $e";
  $p->q+=$e;
  if($p->q >= $p->w){
      $p->q -= $p->w;
      $p->w*=1.1;
      $p->l++;
    }
  return $p;
}

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
echo "TEST 0.0.10 <|> ";
switch ($arg[0]){
  case "join":
    $_STATE->{$sender} = "{\"j\":1,\"l\":0,\"q\":0,\"w\":10}";
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
