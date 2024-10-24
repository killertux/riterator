<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class FlatMap extends Iterator {
	private Flatten $iterator;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = new Flatten(new Map($iterator, $closure));
	}

	/** @inheritDoc */
	public function next(): Option {
		return $this->iterator->next();
	}
}
