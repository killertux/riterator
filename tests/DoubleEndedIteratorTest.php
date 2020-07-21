<?php

use PHPUnit\Framework\Assert;
use RIterator\DoubleEndedIterator;

class DoubleEndedIteratorTest extends \PHPUnit\Framework\TestCase {

	public function testReverse(): void {
		$result = (new \RIterator\PhpRIteratorsAdapters\ArrayRIterator([1, 2, 3 ,4 ,5]))
			->reverse()
			->collect();

		Assert::assertEquals([5, 4, 3, 2, 1], $result);

		$result = (new \RIterator\PhpRIteratorsAdapters\ArrayRIterator([1, 2, 3 ,4 ,5]))
			->reverse()
			->reverse()
			->collect();
		Assert::assertEquals([1, 2, 3, 4, 5], $result);
	}
}
