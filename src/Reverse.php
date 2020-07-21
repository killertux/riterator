<?php

namespace RIterator;

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