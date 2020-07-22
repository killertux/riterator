<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

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

	public function next(): Option {
		if ($this->should_take) {
			$value = $this->iterator->next();
			$this->n--;
			if ($this->n === 0) {
				$this->should_take = false;
			}
			return $value;
		}
		return Option::createNone();
	}
}