<?php

namespace RIterator;

abstract class IntoIterator implements \IteratorAggregate {

	abstract public function intoIterator(): Iterator;

	public function getIterator(): \Iterator {
		return $this->intoIterator()
			->getIterator();
	}
}
