<?php

class IteratorForTests extends \RIterator\Iterator {

	private $values;

	public function __construct(array $values) {
		$this->values = $values;
	}

	public function next(): mixed {
		return array_shift($this->values);
	}
}
