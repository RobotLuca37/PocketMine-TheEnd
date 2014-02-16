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
		//TODO
	}
	public function genHemiSph(Position $centre, Block $material, $size, $percentage){
		//TODO Note: use Vector3::distance(Vector3) is faster
	}
}
