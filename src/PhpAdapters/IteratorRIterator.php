<?php

namespace RIterator\PhpAdapters;

use RIterator\Iterator;
use RIterator\Option;

class IteratorRIterator extends Iterator {

	/** @var \Iterator */
	private $iterator;
	private $first_iteration = true;

	public function __construct(\Iterator $iterator) {
		$this->iterator = $iterator;
	}

	public function next(): Option {
		$this->doIteration();
		if ($this->iterator->valid()) {
			$value = $this->iterator->current();
			return Option::createSome($value);
		}
		return Option::createNone();
	}

	private function doIteration(): void {
		if ($this->first_iteration) {
			$this->first_iteration = false;
			$this->iterator->rewind();
			return;
		}
		$this->iterator->next();
	}
}