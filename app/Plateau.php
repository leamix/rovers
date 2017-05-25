<?php

namespace app;

class Plateau
{
	/**
	 * @var Coordinates
	 */
	private $nullpoint;
	/**
	 * @var Coordinates
	 */
	private $endpoint;

	public function __construct(array $dimensions)
	{
		$this->nullpoint = new Coordinates([0, 0]);
		$this->endpoint = new Coordinates($dimensions);
	}
}