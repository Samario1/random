<?php

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
echo "TEST 0.0.05 <|> ";
switch ($arg[0]){
  case "join":
    $_STATE->{$sender} = "[{\"j\":1,\"l\":0,\"q\":0,\"w\":10}]";
    break;
  case "me":
    print_r($_STATE->{$sender});
    break;
  case "q1":
    $p = json_decode($_STATE->{$sender})[0];
    $p->q++;
    if($p->q >= $p->w){
      $p->q -= $p->w;
      $p->w*=1.1;
    }
    $_STATE->{$sender} = json_encode($p);
    break;
}
?>
