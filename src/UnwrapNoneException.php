<?php

namespace RIterator;

class UnwrapNoneException extends \Exception {

	public function __construct() {
		parent::__construct("Cannot unwrap a none");
	}
}