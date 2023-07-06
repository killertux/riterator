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

	public function current(): mixed {
		return $this->current_value;
	}

	public function next(): void {
		$this->current_value = $this->internal_iterator->next();
	}

	public function key(): mixed {
		return ++$this->key;
	}

	public function valid(): bool {
		return $this->current_value !== null;
	}

	public function rewind(): void {
		$this->current_value = $this->internal_iterator->next();
	}
}
