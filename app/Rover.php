<?php

namespace app;

class Rover
{
	const NORTH = 'N';
	const SOUTH = 'S';
	const EAST = 'E';
	const WEST = 'W';

	/**
	 * @var Coordinates
	 */
	private $coordinates;
	/**
	 * @var string
	 */
	private $direction;

	public function __construct(Coordinates $coordinates, $direction)
	{
		$this->coordinates = $coordinates;
		$this->direction = $direction;
	}

	public function move()
	{
		switch ($this->direction) {
			case self::NORTH:
				$this->coordinates->y += 1;
				break;
			case self::SOUTH:
				$this->coordinates->y -= 1;
				break;
			case self::EAST:
				$this->coordinates->x += 1;
				break;
			case self::WEST:
				$this->coordinates->x -= 1;
				break;
		}
	}

	public function turnLeft()
	{
		switch ($this->direction) {
			case self::NORTH:
				$this->direction = self::WEST;
				break;
			case self::SOUTH:
				$this->direction = self::EAST;
				break;
			case self::EAST:
				$this->direction = self::NORTH;
				break;
			case self::WEST:
				$this->direction = self::SOUTH;
				break;
		}
	}

	public function turnRight()
	{
		switch ($this->direction) {
			case self::NORTH:
				$this->direction = self::EAST;
				break;
			case self::SOUTH:
				$this->direction = self::WEST;
				break;
			case self::EAST:
				$this->direction = self::SOUTH;
				break;
			case self::WEST:
				$this->direction = self::NORTH;
				break;
		}
	}

	public function getPosition()
	{
		return $this->coordinates.' '.$this->direction;
	}

	public function __toString()
	{
		return $this->getPosition();
	}
}