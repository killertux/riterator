<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class FlatMap extends Iterator {

	/** @var Flatten */
	private $iterator;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = new Flatten(new Map($iterator, $closure));
	}

	public function next(): Option {
		return $this->iterator->next();
	}
}