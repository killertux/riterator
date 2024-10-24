<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;

class Fuse extends Iterator {
	private bool $fused = false;

	public function __construct(private readonly IteratorInterface $iterator) {
	}

	/** @inheritDoc */
	public function next(): Option {
		if ($this->fused) {
			return new None();
		}
		$value = $this->iterator->next();
		if ($value->isNone()) {
			$this->fused = true;
			return $value;
		}
		return $value;
	}
}
