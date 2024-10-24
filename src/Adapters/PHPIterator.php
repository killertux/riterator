<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\Option;

class PHPIterator implements \Iterator {

	private ?Option $current_value = null;
	private $key = 0;

	public function __construct(private readonly Iterator $iterator) {}

	public function current(): mixed {
		return $this->current_value?->match(
			fn($value) => $value,
			fn() => null
		);
	}

	public function next(): void {
		$this->key++;
		$this->current_value = $this->iterator->next();
	}

	public function key(): mixed {
		return $this->key;
	}

	public function valid(): bool {
		return $this->current_value->isSome();
	}

	public function rewind(): void {
		$this->current_value = $this->iterator->next();
	}
}
