<?php
if(!isset($arg[0])){
	die($sender.' : you\'ve to choose enemy!');
}
if($arg[0] == $bot){
	die($bot.' dealt 9001 damage and killed '.$sender);
}
if(rand(0,15)>0){
	die($arg[0].' successfully escaped the battlefield!');
}

$player1 = array(
	"name"		=> $sender,
	"dmg"		=> rand(1,99),
	"critical" 	=> rand(0,rand(1,10))>0?true:false,
	"def"		=> rand(1,45)
);
$player2 = array(
	"name"		=> $arg[0],
	"dmg"		=> rand(1,99),
	"critical" 	=> rand(0,rand(1,10))>0?true:false,
	"def"		=> rand(1,45)
);

$player1['dealtdmg'] = $player1['dmg']*($player1['critical']?2:1) - $player2['def'];
$player2['dealtdmg'] = $player2['dmg']*($player2['critical']?2:1) - $player1['def'];

if($player1['dealtdmg'] > $player2['dealtdmg']){
	echo $player1['name'].' dealt '.($player1['critical']?'critical ':'').$player1['dmg'].' damage and killed '.$player2['name'].' !';
}else if($player2['dealtdmg'] > $player1['dealtdmg']){
	echo $player2['name'].' dealt '.($player2['critical']?'critical ':'').$player2['dmg'].' damage and killed '.$player1['name'].' !';
}else if($player1['dealtdmg'] == $player2['dealtdmg']){
	echo $player1['name'].' and '.$player2['name'].' tied in the battle!';
}
?>
