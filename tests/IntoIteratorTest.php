<?php

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Utils\PrimeNumbers;

class IntoIteratorTest extends TestCase {

	public function testGetIterator(): void {
		$prime_numbers = new PrimeNumbers($limit = 100);
		$first_five_prime_numbers = $prime_numbers->intoIterator()
			->take(5)
			->collect();
		Assert::assertEquals([1, 2, 3, 5, 7], $first_five_prime_numbers);
	}

	public function testForEach(): void {
		$prime_numbers = new PrimeNumbers($limit = 10);
		$results = [];
		foreach ($prime_numbers as $prime_number) {
			$results[] = $prime_number;
		}
		Assert::assertEquals([1, 2, 3, 5, 7, 11, 13, 17, 19, 23], $results);
	}
}
