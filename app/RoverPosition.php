<?php

namespace app;

class RoverPosition
{
	/**
	 * @var Coordinates
	 */
	public $coordinates;
	/**
	 * @var Direction
	 */
	public $direction;

	public function __construct(Coordinates $startPoint, Direction $startDirection)
	{
		$this->coordinates = $startPoint;
		$this->direction = $startDirection;
	}

	public function __toString()
	{
		return $this->coordinates.' '.$this->direction;
	}
}