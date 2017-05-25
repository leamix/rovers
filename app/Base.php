<?php

namespace app;

class Base
{
	/**
	 * @var Rover[]
	 */
	private $rovers;
	/**
	 * @var CommandParser
	 */
	private $parser;
	/**
	 * @var Plateau
	 */
	private $plateau;

	public function __construct()
	{

	}

	public function execute($commandBlock)
	{
		$this->parser = new CommandParser($commandBlock);

		$dimensions = $this->parser->getPlateauDimensions();
		$this->plateau = new Plateau($dimensions);

		$roversPositions = $this->parser->getRoversPositions();
		$roversInstructions = $this->parser->getRoversInstructions();
		$i = 0;

		while (isset($roversPositions[$i]) && isset($roversInstructions[$i])) {
			$rover = $this->enableRover($roversPositions[$i]);
			$this->instructRover($rover, $roversInstructions[$i]);
			$i++;
		}
	}

	private function enableRover(array $params)
	{
		$coordinates = new Coordinates($params);
		$rover = new Rover($coordinates, $params[2]);
		$this->rovers[] = $rover;

		return $rover;
	}

	private function instructRover(Rover $rover, array $instructions)
	{
		foreach ($instructions as $instruction) {
			switch ($instruction) {
				case 'M':
					$rover->move();
					break;
				case 'L':
					$rover->turnLeft();
					break;
				case 'R':
					$rover->turnRight();
					break;
			}
		}
	}

	public function locateRovers()
	{
		$data = [];

		foreach ($this->rovers as $rover) {
			$data[] = [
				'position' => $rover->getPosition()
			];
		}

		return $data;
	}
}