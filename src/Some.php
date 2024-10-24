<?php declare(strict_types=1);

namespace RIterator;

readonly class Some extends Option {

	public function __construct(private mixed $value) {}

	public function isSome(): bool {
		return true;
	}

	public function isNone(): bool {
		return false;
	}

	public function unwrap(): mixed {
		return $this->value;
	}
}