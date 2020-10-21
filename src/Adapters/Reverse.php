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
	public function nextBack() {
		return $this->iterator->next();
	}

	/** @inheritDoc */
	public function next() {
		return $this->iterator->nextBack();
	}
}
