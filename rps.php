<?php
$picks = array("rock","paper","scissors","lizard","spock");
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
"rock_scissors" => "crushed"
);
$playerpick = $arg[0];
$botpick = $picks[array_rand($picks)];
  if ($playerpick == $botpick){
    echo "$sender and $bot both picked $playerpick and tied!";
  }
  else if (isset($win[$playerpick."_".$botpick])){
    echo "$sender picked $playerpick and ".$win[$playerpick."_".$botpick]." $bot's $botpick ";
  } else if (isset($win[$botpick."_".$playerpick])){
    echo "$bot picked $botpick and ".$win[$botpick."_".$playerpick]." $sender's $playerpick ";
  } else {
    echo "$sender - you have to pick one of these, to play this game:".implode(", ",$picks);
  }
?>
