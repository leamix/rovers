<?php

namespace app;

class Station
{
	/**
	 * @var Rover[]
	 */
	public $rovers;
	/**
	 * @var CommandParser
	 */
	private $parser;

	public function execute($commandBlock)
	{
		$this->parser = new CommandParser($commandBlock);

		$dimensions = $this->parser->getPlatoDimensions();
		$plato = new Plato($dimensions);

		$positions = $this->parser->getRoversPositions();
		$instructions = $this->parser->getRoversInstructions();
		$i = 0;

		while (isset($positions[$i]) && isset($instructions[$i])) {
			$this->enableRover($positions[$i], $plato)->move($instructions[$i]);
			$i++;
		}
	}

	private function enableRover(RoverPosition $position, Plato $plato)
	{
		$rover = new Rover($position, $plato);
		$this->rovers[] = $rover;

		return $rover;
	}

	public function locateRovers()
	{
		$data = [];

		if (!empty($this->rovers)) {
			foreach ($this->rovers as $rover) {
				$data[] = [
					'position' => $rover->getPosition()
				];
			}
		}

		return $data;
	}
}