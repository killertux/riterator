<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;
use RIterator\Some;

class ChunkSize extends Iterator
{
    public function __construct(private readonly IteratorInterface $iterator, private readonly int $size) {}

    /** @inheritDoc */
    public function next(): Option {
        $chunk = [];
        while (($value = $this->iterator->next())->isSome()) {
            $chunk[] = $value->unwrap();
            if (count($chunk) == $this->size) {
                return new Some($chunk);
            }
        }
		if (!empty($chunk)) {
			return new Some($chunk);
		}
        return new None();
    }
}