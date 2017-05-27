<?php

namespace tests\unit;

use app\PositionException;
use app\Station;

class StationTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provideDataForRoverFinalPositions
	 */
	public function testRoverFinalPositions($data, $output)
	{
		$base = new Station();
		$base->execute($data);
		$this->assertEquals($base->locateRovers(), $output);
	}

	public function provideDataForRoverFinalPositions()
	{
		return [
			[
				"5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM",
				[['position' => '1 3 N'], ['position' => '5 1 E']],
			],
			[
				"5 5\n3 1 E\nRMRMRMLMLM\n5 5 S\nRMMLMMRM",
				[['position' => '1 0 S'], ['position' => '2 3 W']],
			],
		];
	}

	/**
	 * @dataProvider provideDataForRoverOutOfPlato
	 * @expectedException \app\PositionException
	 */
	public function testRoverOutOfPlato($data)
	{
		$base = new Station();
		$base->execute($data);
	}

	public function provideDataForRoverOutOfPlato()
	{
		return [
			["5 5\n6 6 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM"],
			["5 5\n3 1 E\nLMLMLMLMM\n1 8 S\nMMRMMRMRRM"],
			["5 5\n1 2 N\nLMLMLMRMM\n3 3 E\nMMRMMRMRRM"],
			["5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMMM"],
		];
	}
}
