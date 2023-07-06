<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class FilterMap extends Iterator {

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
			$mapped_value = $closure($value);
			if ($mapped_value !== null) {
				return $mapped_value;
			}
		}
		return null;
	}
}
