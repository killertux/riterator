<?php

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RIterator\None;
use RIterator\Option;
use RIterator\PhpAdapters\IteratorRIterator;
use RIterator\Some;

class IteratorTest extends TestCase
{

	public function testCollect(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->collect();
		Assert::assertEquals([0, 1, 2, 3, 4], $result);
	}

	public function testCollectAsKeyValue(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->map(fn($number) => [$number + 1, $number])
			->collectAsKeyValue();
		Assert::assertEquals([1 => 0, 2 => 1, 3 => 2, 4 => 3, 5 => 4], $result);
	}

	public function testCount(): void
	{
		$count = $this->createSequenceIterator($limit = 5)
			->count();
		Assert::assertEquals(5, $count);
	}

	public function testLast(): void
	{
		$iterator = $this->createSequenceIterator($limit = 5);
		Assert::assertEquals(new Some(4), $iterator->last());
	}

	public function testLastWithAnEmptyGenerator_ShouldReturnNone(): void
	{
		$iterator = $this->createSequenceIterator($limit = 0);
		Assert::assertEquals(new None(), $iterator->last());
	}

	public function testSum(): void
	{
		$iterator = $this->createSequenceIterator($limit = 5);
		Assert::assertEquals(10, $iterator->sum());
	}

	public function testNth(): void
	{
		$iterator = $this->createSequenceIterator($limit = 10);
		Assert::assertEquals(new Some(0), $iterator->nth(0));
		Assert::assertEquals(new Some(1), $iterator->nth(0));
		Assert::assertEquals(new Some(4), $iterator->nth(2));
		Assert::assertEquals(new None, $iterator->nth(10));
	}

	public function testStepBy(): void
	{
		$result = $this->createSequenceIterator($limit = 10)
			->stepBy(3)
			->collect();
		Assert::assertEquals([0, 3, 6, 9], $result);
	}

	public function testStepByPassingZeroAsStep_ShouldThrowException(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Cannot step by intervals of zero');
		$this->createSequenceIterator($limit = 10)
			->stepBy(0);
	}

	public function testChain(): void
	{
		$iterator_1 = $this->createSequenceIterator($limit = 3);
		$iterator_2 = $this->createSequenceIterator($limit = 5);
		$result = $iterator_1
			->chain($iterator_2)
			->collect();
		Assert::assertEquals([0, 1, 2, 0, 1, 2, 3, 4], $result);
	}

	public function testZip(): void
	{
		$iterator_1 = $this->createSequenceIterator($limit = 2);
		$iterator_2 = $this->createRevSequenceIterator($limit = 4);
		$result = $iterator_1
			->zip($iterator_2)
			->collect();
		Assert::assertEquals([[0, 4], [1, 3]], $result);

		$iterator_1 = $this->createSequenceIterator($limit = 4);
		$iterator_2 = $this->createRevSequenceIterator($limit = 2);
		$result = $iterator_1
			->zip($iterator_2)
			->collect();
		Assert::assertEquals([[0, 2], [1, 1]], $result);
	}

	public function testMap(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->map(function (int $i): int {
				return $i ** 2;
			})
			->collect();
		Assert::assertEquals([0, 1, 4, 9, 16], $result);
	}

	public function testForEach(): void
	{
		$result = [];
		$this->createSequenceIterator($limit = 5)
			->forEach(function (int $i) use (&$result) {
				$result[] = $i;
			});
		Assert::assertEquals([0, 1, 2, 3, 4], $result);
	}

	public function testFilter(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->filter(function (int $i): bool {
				return $i % 2 === 0;
			})
			->collect();
		Assert::assertEquals([0, 2, 4], $result);
	}

	public function testFilterMap(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->filterMap(function (int $i): Option {
				if ($i % 2 === 0) {
					return new Some($i ** 2);
				}
				return new None();
			})
			->collect();
		Assert::assertEquals([0, 4, 16], $result);
	}

	public function testEnumerate(): void
	{
		$result = $this->createRevSequenceIterator($limit = 4)
			->enumerate()
			->collect();
		Assert::assertEquals([[0, 4], [1, 3], [2, 2], [3, 1]], $result);
	}

	public function testPeekable(): void
	{
		$iterator = $this->createSequenceIterator($limit = 5)
			->peekable();
		Assert::assertEquals(new Some(0), $iterator->peek());
		Assert::assertEquals(new Some(0), $iterator->peek());
		Assert::assertEquals(new Some(0), $iterator->next());
		Assert::assertEquals(new Some(1), $iterator->peek());
		Assert::assertEquals(new Some(1), $iterator->peek());
	}

	public function testSkipWhile(): void
	{
		$result = $this->createArrayIterator([-1, 0, 1, -2])
			->skipWhile(function (int $i): bool {
				return $i <= 0;
			})
			->collect();
		Assert::assertEquals([1, -2], $result);
	}

	public function testTakeWhile(): void
	{
		$result = $this->createArrayIterator([-1, 0, 1, -2])
			->takeWhile(function (int $i): bool {
				return $i <= 0;
			})
			->collect();
		Assert::assertEquals([-1, 0], $result);
	}

	public function testSkip(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->skip(3)
			->collect();
		Assert::assertEquals([3, 4], $result);
	}

	public function testTake(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->take(3)
			->collect();
		Assert::assertEquals([0, 1, 2], $result);
	}

	public function testScan(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->scan(0, function (&$state, int $value): Option {
				$state += $value;
				return new Some(-$state);
			})
			->collect();
		Assert::assertEquals([0, -1, -3, -6, -10], $result);
	}

	public function testFlatten(): void
	{
		$result = $this->createArrayIterator([
			1,
			[2, 3],
			$this->createArrayIterator([4, 5]),
			new \ArrayIterator([6, 7]),
			[[8]]
		])
			->flatten()
			->collect();
		Assert::assertEquals([1, 2, 3, 4, 5, 6, 7, [8]], $result);
	}

	public function testFlatMap(): void
	{
		$result = $this->createSequenceIterator($limit = 3)
			->flatMap(function (int $i): array {
				return [$i, $i + 1];
			})
			->collect();
		Assert::assertEquals([0, 1, 1, 2, 2, 3], $result);
	}

	public function testFuse(): void
	{
		$values = [new Some(1), new None(), new Some(3)];
		$iterator = new IteratorForTests($values);
		self::assertEquals(new Some(1), $iterator->next());
		self::assertEquals(new None, $iterator->next());
		self::assertEquals(new Some(3), $iterator->next());

		$iterator = new IteratorForTests($values);
		$iterator = $iterator->fuse();
		self::assertEquals(new Some(1), $iterator->next());
		self::assertEquals(new None, $iterator->next());
		self::assertEquals(new None, $iterator->next());
	}

	public function testInspect(): void
	{
		$output = '';
		$result = $this->createSequenceIterator($limit = 3)
			->inspect(function (int $i) use (&$output) {
				$output .= $i;
			})
			->collect();
		Assert::assertEquals('012', $output);
		Assert::assertEquals([0, 1, 2], $result);
	}

	public function testPartition(): void
	{
		[$even, $odd] = $this->createSequenceIterator($limit = 10)
			->partition(function (int $i): bool {
				return $i % 2 === 0;
			});
		Assert::assertEquals([0, 2, 4, 6, 8], $even);
		Assert::assertEquals([1, 3, 5, 7, 9], $odd);
	}

	public function testFold(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->fold(0, function (int $acc, int $value): int {
				return $acc + $value;
			});
		Assert::assertEquals(10, $result);
	}

	public function testAllTrue(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->all(function (int $i): bool {
				return $i < 5;
			});
		Assert::assertEquals(true, $result);
	}

	public function testAllFalse(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->all(function (int $i): bool {
				return $i < 3;
			});
		Assert::assertEquals(false, $result);
	}

	public function testAnyTrue(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->any(function (int $i): bool {
				return $i > 3;
			});
		Assert::assertEquals(true, $result);
	}

	public function testAnyFalse(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->any(function (int $i): bool {
				return $i > 4;
			});
		Assert::assertEquals(false, $result);
	}

	public function testFind_ShouldFind(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->find(function (int $i): bool {
				return $i === 3;
			});
		Assert::assertEquals(new Some(3), $result);
	}

	public function testFind_ShouldNotFind(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->find(function (int $i): bool {
				return $i === 5;
			});
		Assert::assertEquals(new None(), $result);
	}

	public function testFindMap_ShouldFind(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->findMap(function (int $i): Option {
				if ($i === 3) {
					return new Some($i ** 2);
				}
				return new None();
			});
		Assert::assertEquals(new Some(9), $result);
	}

	public function testFindMap_ShouldNotFind(): void
	{
		$result = $this->createSequenceIterator($limit = 5)
			->findMap(function (int $i): Option {
				if ($i === 5) {
					return new Some($i ** 2);
				}
				return new None();
			});
		Assert::assertEquals(new None(), $result);
	}

	public function testPosition_ShouldFind(): void
	{
		$result = $this->createRevSequenceIterator($limit = 5)
			->position(function (int $i): int {
				return $i === 3;
			});
		Assert::assertEquals(new Some(2), $result);
	}

	public function testPosition_ShouldNotFind(): void
	{
		$result = $this->createRevSequenceIterator($limit = 5)
			->position(function (int $i): int {
				return $i === -1;
			});
		Assert::assertEquals(new None(), $result);
	}

	public function testUseIteratorInAForEach(): void
	{
		$iterator = $this->createArrayIterator([1, 2, 3, 4, 5]);
		$sum = 0;
		foreach ($iterator as $value) {
			$sum += $value;
		}
		Assert::assertEquals(15, $sum);
	}

	public function testChunkSize(): void
	{
		$result = $this->createSequenceIterator(10)
			->chunk(3)
			->collect();
		Assert::assertEquals([[0, 1, 2], [3, 4, 5], [6, 7, 8], [9]], $result);
	}

	public function testChunkWhile(): void
	{
		$result = $this->createSequenceIterator(10)
			->chunkWhile(fn(int $value) => (int) ($value / 4))
			->collect();

		Assert::assertEquals([[0, 1, 2, 3], [4, 5, 6, 7], [8, 9]], $result);
	}

	private function createSequenceIterator(int $limit): \RIterator\Iterator
	{
		$generator = function (int $limit) {
			for ($i = 0; $i < $limit; $i++) {
				yield $i;
			}
		};
		return new IteratorRIterator($generator($limit));
	}

	private function createRevSequenceIterator(int $limit): \RIterator\Iterator
	{
		$generator = function (int $limit) {
			for ($i = $limit; $i > 0; $i--) {
				yield $i;
			}
		};
		return new IteratorRIterator($generator($limit));
	}

	private function createArrayIterator(array $array): \RIterator\Iterator
	{
		return new \RIterator\PhpAdapters\ArrayRIterator($array);
	}
}