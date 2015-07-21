<?php
$picks = array("rock","paper","scissors","lizard","spock","terrarian");
$win = array(
"scissors_paper" => "cut", 
"paper_rock" => "covered", 
"rock_lizard" => "crushed", 
"lizard_spock" => "poisoned", 
"spock_scissors" => "smashed", 
"scissors_lizard" => "decapitated",
"lizard_paper" => "ate",
"paper_spock" => "disproved",
"spock_rock" => "vaporized", 
"rock_scissors" => "crushed",
"terrarian_lizard" => "strangled",
"terrarian_spock" => "out-yoyo'ed",
"terrarian_rock" => "lassoed",
"scissors_terrarian" => "destrung"
);
$playerpick = isset($arg[0])?$arg[0]:die("$sender - you have to pick one of these, to play this game: ".implode(", ",array_map("ucfirst",$picks)));
$playerpick=="help"?die("Welcome to RPS Shocky edition. You can see the code at: https://github.com/MRokas/random/blob/master/rps.php And if you want to play, you have to pick one of these: ".implode(", ",array_map("ucfirst",$picks))):"";
$botpick = $picks[array_rand($picks)];
  if (isset($win[$playerpick."_".$botpick])){
    echo "$sender picked $playerpick and ".$win[$playerpick."_".$botpick]." $bot's $botpick ";
  } else if (isset($win[$botpick."_".$playerpick])){
    echo "$bot picked $botpick and ".$win[$botpick."_".$playerpick]." $sender's $playerpick ";
  } else if ($playerpick == $botpick){
    echo "$sender and $bot both picked $playerpick and tied!";
  } else if(in_array($playerpick,$picks)){
    echo "$sender's $playerpick tied against $bot's $botpick";
  } else {
    echo "$sender - you have to pick one of these, to play this game: ".implode(", ",array_map("ucfirst",$picks));
  }
?>
