<?php

namespace app;

class Coordinates
{
	public $x = 0;
	public $y = 0;

	public function __construct(array $xy)
	{
		$this->x = (int)$xy[0];
		$this->y = (int)$xy[1];
	}

	public function __toString()
	{
		return $this->x.' '.$this->y;
	}
}