<?php

namespace RIterator\PhpAdapters;

use RIterator\Iterator;
use RIterator\None;
use RIterator\Option;
use RIterator\Some;

class IteratorRIterator extends Iterator {

	private $first_iteration = true;

	public function __construct(private \Iterator $iterator) {}

	public function next(): Option {
		$this->doIteration();
		if ($this->iterator->valid()) {
			return new Some($this->iterator->current());
		}
		return new None();
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
