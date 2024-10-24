<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Map extends Iterator {
	/** @var callable */
	private $closure;

	public function __construct(private readonly IteratorInterface $iterator, callable $closure) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): Option {
		$value = $this->iterator->next();
		$closure = &$this->closure;
		return $value->map($closure);
	}
}
