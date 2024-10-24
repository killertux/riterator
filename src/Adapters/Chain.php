<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Chain extends Iterator {
	private $first_iterator_finished = false;

	public function __construct(private readonly IteratorInterface $iterator_1, private readonly IteratorInterface $iterator_2) {
	}

	/** @inheritDoc */
	public function next(): Option {
		if (!$this->first_iterator_finished) {
			return $this->getNextFromFirstIterator();
		}
		return $this->iterator_2->next();
	}

	private function getNextFromFirstIterator(): Option {
		$value = $this->iterator_1->next();
		if ($value->isNone()) {
			$this->first_iterator_finished = true;
			return $this->next();
		}
		return $value;
	}
}
