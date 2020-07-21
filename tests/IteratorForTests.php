<?php

class IteratorForTests extends \RIterator\Iterator {
	public $values;

	public function next(): \RIterator\Option {
		return array_shift($this->values);
	}
}