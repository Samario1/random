<?php

/*
 * Author: https://github.com/MRokas
 * Version: 0.1
 * Description: smart ?bosschallenge for Shocky. 
 *              No more copper shortsword against Moon Lord, on Last Prism against Eater of the Worlds.
*/

$BOSS_LIST = array(
  "1" => array(
    "King Slime",
    "Eye of Cthulhu",
    "Eater of the World",
    "Brain of Cthulhu",
    "Queen Bee"
  ),
  "2" => array(
    "Skeletron",
    "Wall of Flesh",
  ),
  "3" => array(
    "The Destroyer",
    "The Twins",
    "Skeletron Prime"
  ),
  "4" => array(
    "Plantera",
    "Golem",
  ),
  "5" => array(
    "Duke Fishron"
  ),
  "6" => array(
    "Lunatic Cultist",
    "Vortex Pillar",
    "Nebula Pillar",
    "Solar Pillar",
    "Stardust Pillar",
    "Moon Lord"
  )
);
$WEAPON_LIST = array(
	"1" => array(
		"Copper Bow",
		"Copper Hammer",
		"Copper Axe",
		"Copper Shortsword",
		"Copper Broadsword",
		"Copper Pickaxe",
		"Silver Bow",
		"Silver Hammer",
		"Silver Axe",
		"Silver Shortsword",
		"Silver Broadsword",
		"Silver Pickaxe",
		"Gold Bow",
		"Gold Hammer",
		"Gold Axe",
		"Gold Shortsword",
		"Gold Broadsword",
		"Gold Pickaxe",
		"Iron Pickaxe",
		"Iron Broadsword",
		"Iron Shortsword",
		"Iron Hammer",
		"Iron Axe",
		"Wooden Sword",
		"Wooden Bow",
		"Platinum Bow",
		"Platinum Hammer",
		"Platinum Axe",
		"Platinum Shortsword",
		"Platinum Broadsword",
		"Platinum Pickaxe",
		"Tungsten Bow",
		"Tungsten Hammer",
		"Tungsten Axe",
		"Tungsten Shortsword",
		"Tungsten Broadsword",
		"Tungsten Pickaxe",
		"Lead Bow",
		"Lead Hammer",
		"Lead Axe",
		"Lead Shortsword",
		"Lead Broadsword",
		"Lead Pickaxe",
		"Tin Bow",
		"Tin Hammer",
		"Tin Axe",
		"Tin Shortsword",
		"Tin Broadsword",
		"Tin Pickaxe",
		"Cactus Sword",
		"Cactus Pickaxe",
		"Shadewood Sword",
		"Shadewood Hammer",
		"Shadewood Bow",
		"Ebonwood Sword",
		"Ebonwood Hammer",
		"Ebonwood Bow",
		"Rich Mahogany Sword",
		"Rich Mahogany Hammer",
		"Rich Mahogany Bow",
		"Pearlwood Sword",
		"Pearlwood Hammer",
		"Pearlwood Bow",
		"Spear",
		"Blowpipe",
		"Wooden Boomerang",
		"Grenade",
		
	),
	"2" => array(
	
	),
	"3" => array(
	
	),
	"4" => array(
	
	),
	"5" => array(
	
	),
	"6" => array(
	
	),
);

//$tier = rand(1,6);
$tier = '1';

echo $sender.' you must kill '.$BOSS_LIST['1'][array_rand($BOSS_LIST['1'])].' using The '.$WEAPON_LIST['1'][array_rand($WEAPON_LIST['1'])];
?>
