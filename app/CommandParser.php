<?php

namespace app;

class CommandParser
{
	private $plateauDimensions;
	private $roverPositions;
	private $roverInstructions;

	public function __construct($commandBlock)
	{
		$this->ensureIsNotEmpty($commandBlock);
		$this->ensureIsString($commandBlock);
		$lines = $this->fetchCommands($commandBlock);
		$i = 0;

		$this->plateauDimensions = $this->parsePlateauDimensions($lines[$i++]);
		while (isset($lines[$i]) && isset($lines[$i+1])) {
			$this->roverPositions[] = $this->parseRoverPosition($lines[$i++]);
			$this->roverInstructions[] = $this->parseRoverInstructions($lines[$i++]);
		}
	}

	private function fetchCommands($commandBlock)
	{
		$lines = explode("\n", $commandBlock);
		$lines = array_map('trim', $lines);
		return array_diff($lines, [null, '']);
	}

	public function parseRoverInstructions($instructions)
	{
		if (!preg_match('/^[L|R|M]+$/', $instructions)) {
			throw new CommandException('Rover #'.(count($this->roverInstructions)+1).' instruction is invalid.');
		}
		preg_match_all('/[L|R|M]/', $instructions, $matches);
		return $matches[0];
	}

	public function parseRoverPosition($position)
	{
		if (!preg_match('/^(\d+) (\d+) (N|S|E|W)$/', $position, $matches)) {
			throw new CommandException('Rover #'.(count($this->roverPositions)+1).' position is invalid.');
		}
		return [(int)$matches[1], (int)$matches[2], $matches[3]];
	}

	public function parsePlateauDimensions($dimensions)
	{
		if (!preg_match('/^(\d+) (\d+)$/', $dimensions, $matches)) {
			throw new CommandException('Plateau dimensions are invalid.');
		}
		return [(int)$matches[1], (int)$matches[2]];
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
	 * @param string $commandBlock
	 */
	private function ensureIsString($commandBlock)
	{
		if (!is_string($commandBlock)) {
			throw new CommandException('Command must be a string.');
		}
	}

	public function getPlateauDimensions()
	{
		return $this->plateauDimensions;
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