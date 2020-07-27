<?php

use PHPUnit\Framework\Assert;
use RIterator\DoubleEndedIterator;

class DoubleEndedIteratorTest extends \PHPUnit\Framework\TestCase {

	public function testNextAndNextBack(): void {
		$double_ended_iterator = new \RIterator\PhpAdapters\ArrayRIterator([1, 2, 3 ,4 ,5]);
		$this->assertEquals(1, $double_ended_iterator->next()->unwrap());
		$this->assertEquals(5, $double_ended_iterator->nextBack()->unwrap());
		$this->assertEquals(2, $double_ended_iterator->next()->unwrap());
		$this->assertEquals(4, $double_ended_iterator->nextBack()->unwrap());
		$this->assertEquals(3, $double_ended_iterator->next()->unwrap());
		$this->assertTrue($double_ended_iterator->nextBack()->isNone());
		$this->assertTrue($double_ended_iterator->next()->isNone());
	}

	public function testReverse(): void {
		$result = (new \RIterator\PhpAdapters\ArrayRIterator([1, 2, 3 ,4 ,5]))
			->reverse()
			->collect();

		Assert::assertEquals([5, 4, 3, 2, 1], $result);

		$result = (new \RIterator\PhpAdapters\ArrayRIterator([1, 2, 3 ,4 ,5]))
			->reverse()
			->reverse()
			->collect();
		Assert::assertEquals([1, 2, 3, 4, 5], $result);
	}
}
