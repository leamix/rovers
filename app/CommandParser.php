<?php

namespace app;

class CommandParser
{
	/**
	 * @var Coordinates
	 */
	private $platoDimensions;
	/**
	 * @var RoverPosition[]
	 */
	private $roverPositions;
	/**
	 * @var array
	 */
	private $roverInstructions;

	public function __construct($command)
	{
		$this->ensureIsNotEmpty($command);
		$this->ensureIsString($command);
		$lines = $this->fetchCommands($command);
		$i = 0;

		$this->parsePlatoDimensions($lines[$i++]);

		while (isset($lines[$i]) && isset($lines[$i+1])) {
			$this->parseRoverPosition($lines[$i++]);
			$this->parseRoverInstructions($lines[$i++]);
		}

		if (empty($this->roverPositions) || empty($this->roverInstructions)) {
			throw new CommandException('Command is incomplete.');
		}
	}

	public function parsePlatoDimensions($dimensions)
	{
		if (!preg_match('/^(\d+) (\d+)$/', $dimensions, $matches)) {
			throw new CommandException('Plato dimensions are invalid.');
		}

		$this->platoDimensions = new Coordinates([$matches[1], $matches[2]]);
	}

	public function parseRoverPosition($position)
	{
		if (!preg_match('/^(\d+) (\d+) (N|S|E|W)$/', $position, $matches)) {
			throw new CommandException('Rover #'.(count($this->roverPositions)+1).' position is invalid.');
		}

		$this->roverPositions[] = new RoverPosition(
			new Coordinates([$matches[1], $matches[2]]),
			new Direction($matches[3])
		);
	}

	public function parseRoverInstructions($instructions)
	{
		if (!preg_match('/^[L|R|M]+$/', $instructions)) {
			throw new CommandException('Rover #'.(count($this->roverInstructions)+1).' instructions are invalid.');
		}
		preg_match_all('/[L|R|M]/', $instructions, $matches);

		$this->roverInstructions[] = $matches[0];
	}

	private function fetchCommands($command)
	{
		$lines = explode("\n", $command);
		$lines = array_map('trim', $lines);

		return array_diff($lines, [null, '']);
	}

	/**
	 * @param mixed $command
	 */
	private function ensureIsNotEmpty($command)
	{
		if (empty($command)) {
			throw new CommandException('Command can not be empty.');
		}
	}

	/**
	 * @param string $command
	 */
	private function ensureIsString($command)
	{
		if (!is_string($command)) {
			throw new CommandException('Command must be a string.');
		}
	}

	public function getPlatoDimensions()
	{
		return $this->platoDimensions;
	}

	public function getRoversPositions()
	{
		return $this->roverPositions;
	}

	public function getRoversInstructions()
	{
		return $this->roverInstructions;
	}
}