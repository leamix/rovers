<?php

namespace tests\unit;

use \app\CommandParser;

class CommandParserTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \app\CommandException
	 * @expectedExceptionMessage Command can not be empty.
	 */
	public function testExceptionOnValidateEmptyData()
	{
		$parser = new CommandParser([]);
	}

	/**
	 * @expectedException \app\CommandException
	 * @expectedExceptionMessage Command must be a string.
	 */
	public function testExceptionOnValidateArray()
	{
		$parser = new CommandParser(['command' => "5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM"]);
	}

	/**
	 * @expectedException \app\CommandException
	 * @expectedExceptionMessage Plateau dimensions are invalid.
	 * @dataProvider provideDataForExceptionOnValidateDimensions
	 */
	public function testExceptionOnValidateDimensions($data)
	{
		$parser = new CommandParser($data);
	}

	public function provideDataForExceptionOnValidateDimensions()
	{
		return [
			["55"],
			["5 5F"],
		];
	}

	/**
	 * @expectedException \app\CommandException
	 * @expectedExceptionMessageRegExp #Rover \#\d+ instruction|position is invalid.#
	 * @dataProvider provideDataForExceptionOnValidateRover
	 */
	public function testExceptionOnValidateRover($data)
	{
		$parser = new CommandParser($data);
	}

	public function provideDataForExceptionOnValidateRover()
	{
		return [
			["5 5\n1 -2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM"],
			["5 5\n1 2 N\nLMLM LMLMM\n3 3 E\nMMRMMRMRRM"],
			["5 5\n1 2 N\nLMLMLMLMM\n3 asd3 E\nMMRMMRMRRM"],
			["5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMM-RMRRM"],
		];
	}

	/**
	 * @dataProvider provideDataForParser
	 */
	public function testParser($data, $dimensions, $roversPos, $roversInstr)
	{
		$parser = new CommandParser($data);
		$this->assertSame($parser->getPlateauDimensions(), $dimensions);
		$this->assertSame($parser->getRoversPositions(), $roversPos);
		$this->assertSame($parser->getRoversInstructions(), $roversInstr);
	}

	public function provideDataForParser()
	{
		return [
			[
				"5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM",
				[5, 5],
				[[1, 2, 'N'], [3, 3, 'E']],
				[['L','M','L','M','L','M','L','M','M'], ['M','M','R','M','M','R','M','R','R','M']]
			],
			[
				"10 10\n0 5 W\nLMM\n1 2 S\nMMR",
				[10, 10],
				[[0, 5, 'W'], [1, 2, 'S']],
				[['L','M','M'], ['M','M','R']]
			],
			[
				"10 10\n3 2 S\nRMM",
				[10, 10],
				[[3, 2, 'S']],
				[['R','M','M']]
			],
		];
	}
}
