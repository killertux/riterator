<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class StepBy extends Iterator {

	private $first_iteration = true;

	public function __construct(private readonly IteratorInterface $iterator, private int $n) {
		if ($n === 0) {
			throw new \InvalidArgumentException('Cannot step by intervals of zero');
		}
	}

	/** @inheritDoc */
	public function next(): Option {
		if ($this->first_iteration) {
			$this->first_iteration = false;
			return $this->iterator->next();
		}
		for ($i = 0; $i < $this->n - 1; $i++) {
			$this->iterator->next();
		}
		return $this->iterator->next();
	}

}
