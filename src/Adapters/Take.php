<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Take extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var int */
	private $n;
	private $should_take = true;

	public function __construct(IteratorInterface $iterator, int $n) {
		$this->iterator = $iterator;
		$this->n = $n;
	}

	/** @inheritDoc */
	public function next(): mixed {
		if ($this->should_take) {
			$value = $this->iterator->next();
			$this->n--;
			if ($this->n === 0) {
				$this->should_take = false;
			}
			return $value;
		}
		return null;
	}
}
