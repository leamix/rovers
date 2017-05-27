<?php

namespace app;

class Plato
{
	/**
	 * @var Coordinates
	 */
	public $nullpoint;
	/**
	 * @var Coordinates
	 */
	public $endpoint;

	public function __construct(Coordinates $endPoint)
	{
		$this->nullpoint = new Coordinates([0, 0]);
		$this->endpoint = $endPoint;
	}
}