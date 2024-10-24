<?php declare(strict_types=1);

namespace RIterator;

readonly class None extends Option {

	public function isSome(): bool {
		return false;
	}

	public function isNone(): bool {
		return true;
	}

	public function unwrap(): mixed {
		throw new \RuntimeException('Cannot unwrap None');
	}
}