<?php

namespace RIterator;

use RIterator\Adapters\Reverse;

abstract class DoubleEndedIterator extends Iterator implements DoubleEndedIteratorInterface {

	/**
	 * @inheritDoc
	 */
	abstract public function nextBack(): mixed;

	/**
	 * @inheritDoc
	 */
	abstract public function next(): mixed;

	public function reverse(): Reverse {
		return new Reverse($this);
	}
}
