<?php

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp
echo "TEST 0.0.03 <|> ";
switch ($arg[0]){
  case "join":
    $_STATE->{$sender} = "[{\"j\":1,\"l\":0,\"q\":0,\"w\":10}]";
    break;
  case "me":
    print_r(json_decode($_STATE->{$sender},true));
    break;
  case "q1":
    $_STATE->{$sender}->q++;
    if($_STATE->{$sender}->q >= $_STATE->{$sender}->w){
      $_STATE->{$sender}->q -= $_STATE->{$sender}->w;
      $_STATE->{$sender}->w*=1.1;
    }
    break;
}
?>
