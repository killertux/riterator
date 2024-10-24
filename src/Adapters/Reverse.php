<?php

namespace RIterator\Adapters;

use RIterator\DoubleEndedIterator;
use RIterator\DoubleEndedIteratorInterface;
use RIterator\Option;

class Reverse extends DoubleEndedIterator {

	public function __construct(private readonly DoubleEndedIteratorInterface $iterator) {
	}

	/** @inheritDoc */
	public function nextBack(): Option {
		return $this->iterator->next();
	}

	/** @inheritDoc */
	public function next(): Option {
		return $this->iterator->nextBack();
	}
}
