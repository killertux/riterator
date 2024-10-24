<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class SkipWhile extends Iterator {

	/** @var callable */
	private $closure;
	private bool $skipping = true;

	public function __construct(private readonly IteratorInterface $iterator, callable $closure) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
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
