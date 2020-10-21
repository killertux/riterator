<?php

namespace PhpAdapters;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RIterator\PhpAdapters\ArrayRIterator;

class ArrayRIteratorTest extends TestCase {

	public function testUnsetInArray(): void {
		$array = [1, 2, 3 ,4];
		unset($array[2]);
		Assert::assertEquals([1, 2, 4], (new ArrayRIterator($array))->collect());
	}

	public function testArrayWithNulls(): void {
		$array = [1, 2, null ,4];
		$iterator = new ArrayRIterator($array);
		Assert::assertEquals(1, $iterator->next());
		Assert::assertEquals(2, $iterator->next());
		Assert::assertEquals(null, $iterator->next());
		Assert::assertEquals(4, $iterator->next());
	}

	public function testCollectArrayWithNulls_WillFuse(): void {
		$array = [1, 2, null ,4];
		Assert::assertEquals([1, 2], (new ArrayRIterator($array))->collect());
	}
}
