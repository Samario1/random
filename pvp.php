<?php
if(!isset($arg[0])){
	die($sender.' : you\'ve to choose enemy!');
}
if($arg[0] == $bot){
	die($bot.' dealt 9001 damage and killed '.$sender);
}

$player1 = array(
	"name"	=> $sender,
	"dmg"	=> rand(1,99),
	"def"	=> rand(1,99)
);
$player2 = array(
	"name"	=> $arg[0],
	"dmg"	=> rand(1,99),
	"def"	=> rand(1,99)
);
$defp = rand(1,10)/10;

$player1['dealtdmg'] = $player1['dmg'] - $player2['def']*$defp;
$player2['dealtdmg'] = $player2['dmg'] - $player1['def']*$defp;

if($player1['dealtdmg'] > $player2['dealtdmg']){
	echo $player1['name'].' dealt '.$player1['dmg'].' damage and killed '.$player2['name'].'!';
}else if($player2['dealtdmg'] > $player1['dealtdmg']){
	echo $player2['name'].' dealt '.$player2['dmg'].' damage and killed '.$player1['name'].'!';
}else if($player1['dealtdmg'] == $player2['dealtdmg']){
	echo $player1['name'].' and '.$player2['name'].' tied in the battle!';
}
?>
