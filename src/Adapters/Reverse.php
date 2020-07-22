<?php

namespace RIterator\Adapters;

use RIterator\DoubleEndedIterator;
use RIterator\DoubleEndedIteratorInterface;
use RIterator\Option;

class Reverse extends DoubleEndedIterator {

	/** @var DoubleEndedIteratorInterface */
	private $iterator;

	public function __construct(DoubleEndedIteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	public function nextBack(): Option {
		return $this->iterator->next();
	}

	public function next(): Option {
		return $this->iterator->nextBack();
	}
}