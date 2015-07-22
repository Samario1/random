<?php

if(!isset($arg[0]))
  $arg[0] = 'info';

switch ($arg[0]){
  case 'link':
    echo 'https://github.com/TerrariaPrismTeam/Prism';
    break;
  case 'info':
    echo 'Prism is modding API for Terraria 1.3 and above. Currently it's in development stage, check out progress here: https://github.com/TerrariaPrismTeam/Prism';
    break;
  default:
    echo 'Prism is modding API for Terraria 1.3 and above. Currently it's in development stage, check out progress here: https://github.com/TerrariaPrismTeam/Prism';
}

?>
