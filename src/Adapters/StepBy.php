<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class StepBy extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var int */
	private $n;
	private $first_iteration = true;

	public function __construct(IteratorInterface $iterator, int $n) {
		$this->iterator = $iterator;
		if ($n === 0) {
			throw new \InvalidArgumentException('Cannot step by intervals of zero');
		}
		$this->n = $n;
	}

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