<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;

class Take extends Iterator {

	public function __construct(private readonly IteratorInterface $iterator, private int $n) {
	}

	/** @inheritDoc */
	public function next(): Option {
		if ($this->n > 0) {
			$this->n--;
			return $this->iterator->next();
		}
		return new None();
	}
}
