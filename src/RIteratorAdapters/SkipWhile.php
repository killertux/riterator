<?php

namespace RIterator\RIteratorAdapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

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

	public function next(): Option {
		if ($this->skipping) {
			return $this->handleSkipping();
		}
		return $this->iterator->next();
	}

	private function handleSkipping(): Option {
		$closure = &$this->closure;
		do {
			$value = $this->iterator->next();
			if ($value->isNone()) {
				break;
			}
		} while ($closure($value->unwrap()));
		$this->skipping = false;
		return $value;
	}
}