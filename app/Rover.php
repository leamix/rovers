<?php

namespace app;

class Rover
{
	/**
	 * @var RoverPosition
	 */
	private $position;
	/**
	 * @var Plato
	 */
	private $plato;

	public function __construct(RoverPosition $position, Plato $plato)
	{
		$this->plato = $plato;
		$this->position = $position;
		$this->ensureIsNotOutOfPlato();
	}

	public function move(array $instructions)
	{
		foreach ($instructions as $instruction) {
			switch ($instruction) {
				case 'M':
					$this->moveToDirection();
					break;
				case 'L':
					$this->turnLeft();
					break;
				case 'R':
					$this->turnRight();
					break;
			}
		}
		$this->ensureIsNotOutOfPlato();
	}

	private function ensureIsNotOutOfPlato()
	{
		if ($this->position->coordinates->x < $this->plato->nullpoint->x ||
			$this->position->coordinates->y < $this->plato->nullpoint->y ||
			$this->position->coordinates->x > $this->plato->endpoint->x ||
			$this->position->coordinates->y > $this->plato->endpoint->y
		) {
			throw new PositionException('Rover is out of plato.');
		}
	}

	private function moveToDirection()
	{
		switch ($this->position->direction->getValue()) {
			case Direction::NORTH:
				$this->position->coordinates->y += 1;
				break;
			case Direction::SOUTH:
				$this->position->coordinates->y -= 1;
				break;
			case Direction::EAST:
				$this->position->coordinates->x += 1;
				break;
			case Direction::WEST:
				$this->position->coordinates->x -= 1;
				break;
		}
	}

	private function turnLeft()
	{
		$this->position->direction->left();
	}

	private function turnRight()
	{
		$this->position->direction->right();
	}

	public function getPosition()
	{
		return (string)$this->position;
	}

	public function __toString()
	{
		return $this->getPosition();
	}
}