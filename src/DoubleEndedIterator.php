<?php

namespace RIterator;

abstract class DoubleEndedIterator extends Iterator implements DoubleEndedIteratorInterface {

	/**
	 * @inheritDoc
	 */
	abstract public function nextBack(): Option;

	/**
	 * @inheritDoc
	 */
	abstract public function next(): Option;

	public function reverse(): Reverse {
		return new Reverse($this);
	}
}