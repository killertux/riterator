<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Map extends Iterator {

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
		$value = $this->iterator->next();
		$closure = &$this->closure;
		if ($value !== null) {
			return $closure($value);
		}
		return null;
	}
}
