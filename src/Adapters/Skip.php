<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Skip extends Iterator {

	public function __construct(private readonly IteratorInterface $iterator, private int $n) {
	}

	/** @inheritDoc */
	public function next(): Option {
		if ($this->n > 0) {
			for (; $this->n > 0; $this->n--) {
				$this->iterator->next();
			}
		}
		return $this->iterator->next();
	}
}
