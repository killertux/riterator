<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class SkipWhile extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;
	private $skipping = true;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = $iterator;
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): mixed {
		if ($this->skipping) {
			return $this->handleSkipping();
		}
		return $this->iterator->next();
	}

	private function handleSkipping() {
		$closure = &$this->closure;
		do {
			$value = $this->iterator->next();
			if ($value === null) {
				break;
			}
		} while ($closure($value));
		$this->skipping = false;
		return $value;
	}
}
