<?php

namespace RIterator\Adapters;

use RIterator\DoubleEndedIterator;
use RIterator\DoubleEndedIteratorInterface;

class Reverse extends DoubleEndedIterator {

	/** @var DoubleEndedIteratorInterface */
	private $iterator;

	public function __construct(DoubleEndedIteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	/** @inheritDoc */
	public function nextBack(): mixed {
		return $this->iterator->next();
	}

	/** @inheritDoc */
	public function next(): mixed {
		return $this->iterator->nextBack();
	}
}
