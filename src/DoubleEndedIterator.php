<?php

namespace RIterator;

use RIterator\Adapters\Reverse;

abstract class DoubleEndedIterator extends Iterator implements DoubleEndedIteratorInterface {

	/**
	 * @inheritDoc
	 */
	abstract public function nextBack();

	/**
	 * @inheritDoc
	 */
	abstract public function next();

	public function reverse(): Reverse {
		return new Reverse($this);
	}
}
