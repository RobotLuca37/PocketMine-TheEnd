<?php

/*
__PocketMine Plugin__
class=TheEndPlugin
name=The End
author=PEMapModder
version=alpha 0.0
apiversion=12
*/

define("ENDSTONE_SUBST", SANDSTONE);

class TheEndPlugin implements Plugin{
	public function __construct(ServerAPI $a, $s=0){}
	public function __destruct(){}
	public function init(){}
	public function generateTheEnd(Level $level, $seed = false){
		$name = $level->getName()."_ext_the_end";
		$lg = new SuperflatGenerator(array(
				"preset" => "2"
		));
		$wg = new WorldGenerator($lg, $name, $seed);
		$wg->generate();
		$wg->close();
		$this->api->level->loadLevel($name);
		$end = $this->api->level->get($name);
		$this->genHemiSph($this->randPos(new Position(128, 48, 128, $end), new Vector3(64, 24, 64)), BlockAPI::get(ENDSTONE_SUBST), mt_rand(16, 24), 50);
	}
	public function randPos(Position $principal, Vector3 $maxVar){
		return new Position(
			$principal->x + mt_rand(-1 * abs($maxVar->x), abs($maxVar->x)),
			$principal->y + mt_rand(-1 * abs($maxVar->y), abs($maxVar->y)),
			$principal->z + mt_rand(-1 * abs($maxVar->z), abs($maxVar->z)),
			$principal->level);
	}
	public function genHemiSph(Position $centre, Block $material, $radius, $vertPerct){
		$startX = $centre->x - $radius;
		$startY = $centre->y - $radius;
		$startZ = $centre->z - $radius;
		$endX = $centre->x + $radius;
		$endZ = $centre->z + $radius;
		$endY = $startY + $radius * 2 * $vertPerct / 100;
		for($x=$startX; $x<=$endX; $x++){
			for($y=$startY; $y<=$endY; $y++){
				for($z=$startZ; $z<=$endZ; $z++){
					$pos = new Position($x, $y, $z, $centre->level);
					if($pos->distance($centre)<=$radius){
						$centre->level->setBlock($pos, $material);
					}
				}
			}
		}
		return true;
	}
}
