<?php

use RIterator\Option;

class IteratorForTests extends \RIterator\Iterator {

	private $values;

	public function __construct(array $values) {
		$this->values = $values;
	}

	public function next(): Option {
		return array_shift($this->values);
	}
}
