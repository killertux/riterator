<?php

namespace RIterator\RIteratorAdapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Fuse extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	private $fused = false;

	public function __construct(IteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	public function next(): Option {
		if ($this->fused) {
			return Option::createNone();
		}
		$value = $this->iterator->next();
		if ($value->isNone()) {
			$this->fused = true;
			return Option::createNone();
		}
		return $value;
	}
}