<?php

if(!isset($arg[0])){
  if(isset($_STATE["{$sender}"])){
    die($sender.' : Level: 0');
  }
  die('Welcome to swagRPG, use join to start playing!');
}
switch ($arg[0]){
  case "join":
    $_STATE[$sender] = 'Joined';
    break;
  default:
    die('');
}

?>
