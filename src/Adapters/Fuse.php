<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Fuse extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	private $fused = false;

	public function __construct(IteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	/** @inheritDoc */
	public function next(): mixed {
		if ($this->fused) {
			return null;
		}
		$value = $this->iterator->next();
		if ($value === null) {
			$this->fused = true;
			return $this->next();
		}
		return $value;
	}
}
