<?php

namespace app;

class CommandException extends \RuntimeException
{
	public $message = 'Command is invalid.';
}