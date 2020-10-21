<?php

namespace RIterator\Adapters;

use RIterator\Iterator;

class PHPIterator implements \Iterator {

	/** @var Iterator */
	private $internal_iterator;
	private $current_value = null;
	private $key = 0;

	public function __construct(Iterator $iterator) {
		$this->internal_iterator = $iterator;
	}

	public function current() {
		return $this->current_value;
	}

	public function next() {
		$this->current_value = $this->internal_iterator->next();
	}

	public function key() {
		return ++$this->key;
	}

	public function valid() {
		return $this->current_value !== null;
	}

	public function rewind() {
		$this->current_value = $this->internal_iterator->next();
	}
}
