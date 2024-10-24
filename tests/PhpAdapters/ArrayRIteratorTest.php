<?php

namespace PhpAdapters;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RIterator\None;
use RIterator\PhpAdapters\ArrayRIterator;
use RIterator\Some;

class ArrayRIteratorTest extends TestCase {

	public function testUnsetInArray(): void {
		$array = [1, 2, 3 ,4];
		unset($array[2]);
		Assert::assertEquals([1, 2, 4], (new ArrayRIterator($array))->collect());
	}

	public function testArrayWithNulls(): void {
		$array = [1, 2, null ,4];
		$iterator = new ArrayRIterator($array);
		Assert::assertEquals(new Some(1), $iterator->next());
		Assert::assertEquals(new Some(2), $iterator->next());
		Assert::assertEquals(new Some(null), $iterator->next());
		Assert::assertEquals(new Some(4), $iterator->next());
	}
}
