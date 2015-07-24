<?php

// User-data:
// (j) => Joined
// (l) => Level
// (q) => Current Exp
// (w) => Max Exp

switch ($arg[0]){
  case "join":
    $_STATE->{$sender} = "[{"j":1,"l":0,"q":0,"w":10}]";
    break;
  case "me":
    print_r($_STATE->{$sender});
    break;
}
?>
