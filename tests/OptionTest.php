<?php

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RIterator\Option;
use RIterator\UnwrapNoneException;

class OptionTest extends TestCase {

	public function testCreateWithSome(): void {
		$value = 'some-value';
		$option = Option::createSome($value);
		Assert::assertTrue($option->isSome());
		Assert::assertEquals($value, $option->unwrap());
	}

	public function testCreateWithNone(): void {
		$option = Option::createNone();
		Assert::assertTrue($option->isNone());
		Assert::assertSame($option, Option::createNone());
	}

	public function testUnwrapNone_ShouldThrowException(): void {
		$this->expectException(UnwrapNoneException::class);
		$this->expectExceptionMessage('Cannot unwrap a none');
		Option::createNone()->unwrap();
	}
}