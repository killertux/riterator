<?php

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RIterator\PhpAdapters\ArrayRIterator;

class DoubleEndedIteratorTest extends TestCase {

	public function testNextAndNextBack(): void {
		$double_ended_iterator = new ArrayRIterator([1, 2, 3 ,4 ,5]);
		$this->assertEquals(1, $double_ended_iterator->next());
		$this->assertEquals(5, $double_ended_iterator->nextBack());
		$this->assertEquals(2, $double_ended_iterator->next());
		$this->assertEquals(4, $double_ended_iterator->nextBack());
		$this->assertEquals(3, $double_ended_iterator->next());
		$this->assertNull($double_ended_iterator->nextBack());
		$this->assertNull($double_ended_iterator->next());
	}

	public function testReverse(): void {
		$result = (new ArrayRIterator([1, 2, 3 ,4 ,5]))
			->reverse()
			->collect();

		Assert::assertEquals([5, 4, 3, 2, 1], $result);

		$result = (new ArrayRIterator([1, 2, 3 ,4 ,5]))
			->reverse()
			->reverse()
			->collect();
		Assert::assertEquals([1, 2, 3, 4, 5], $result);
	}
}
