<?php

namespace RIterator;

abstract class IntoIterator implements \IteratorAggregate {

	abstract public function intoIterator(): Iterator;

	final public function getIterator(): \Iterator {
		return $this->intoIterator()
			->getIterator();
	}
}
