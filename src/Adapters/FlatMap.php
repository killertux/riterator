<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class FlatMap extends Iterator {

	/** @var Flatten */
	private $iterator;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = new Flatten(new Map($iterator, $closure));
	}

	/** @inheritDoc */
	public function next() {
		return $this->iterator->next();
	}
}
