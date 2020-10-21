<?php

namespace RIterator\PhpAdapters;

use RIterator\Iterator;

class IteratorRIterator extends Iterator {

	/** @var \Iterator */
	private $iterator;
	private $first_iteration = true;

	public function __construct(\Iterator $iterator) {
		$this->iterator = $iterator;
	}

	public function next() {
		$this->doIteration();
		if ($this->iterator->valid()) {
			return $this->iterator->current();
		}
		return null;
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
