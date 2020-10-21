<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Enumerate extends Iterator {

	/** @var int */
	private $enumeration = 0;
	/** @var IteratorInterface */
	private $iterator;

	public function __construct(IteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	/** @inheritDoc */
	public function next() {
		$value = $this->iterator->next();
		if ($value !== null) {
			return [$this->enumeration++, $value];
		}
		return null;
	}
}
