<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Filter extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = $iterator;
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): mixed {
		$closure = &$this->closure;
		while (($value = $this->iterator->next()) !== null) {
			if ($closure($value)) {
				return $value;
			}
		}
		return null;
	}
}
