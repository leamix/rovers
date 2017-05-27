<?php

namespace app;

class Direction
{
	const NORTH = 'N';
	const SOUTH = 'S';
	const EAST = 'E';
	const WEST = 'W';

	/**
	 * @var string
	 */
	private $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function left()
	{
		switch ($this->value) {
			case self::NORTH:
				$this->value = self::WEST;
				break;
			case self::SOUTH:
				$this->value = self::EAST;
				break;
			case self::EAST:
				$this->value = self::NORTH;
				break;
			case self::WEST:
				$this->value = self::SOUTH;
				break;
		}
	}

	public function right()
	{
		switch ($this->value) {
			case self::NORTH:
				$this->value = self::EAST;
				break;
			case self::SOUTH:
				$this->value = self::WEST;
				break;
			case self::EAST:
				$this->value = self::SOUTH;
				break;
			case self::WEST:
				$this->value = self::NORTH;
				break;
		}
	}

	public function getValue()
	{
		return $this->value;
	}

	public function __toString()
	{
		return $this->getValue();
	}
}