<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class TakeWhile extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;
	private $taking = true;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = $iterator;
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): mixed {
		if (!$this->taking) {
			return null;
		}
		$closure = &$this->closure;
		$value = $this->iterator->next();
		if ($closure($value)) {
			return $value;
		}
		$this->taking = false;
		return null;
	}
}
