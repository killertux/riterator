<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Chain extends Iterator {

	/** @var IteratorInterface */
	private $iterator_1;
	/** @var IteratorInterface */
	private $iterator_2;
	private $first_iterator_finished = false;

	public function __construct(IteratorInterface $iterator_1, IteratorInterface $iterator_2) {
		$this->iterator_1 = $iterator_1;
		$this->iterator_2 = $iterator_2;
	}

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