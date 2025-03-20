<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\Collections;

use ArrayIterator;
use Closure;
use IteratorAggregate;
use Libraries\CommonPhpProjectsThings\Collections\Exceptions\InvalidCollectionItemException;
use Libraries\CommonPhpProjectsThings\Collections\Exceptions\InvalidCollectionTypeException;
use Libraries\CommonPhpProjectsThings\Interfaces\ArrayableInterface;
use Libraries\CommonPhpProjectsThings\Interfaces\SerializableInterface;
use Libraries\CommonPhpProjectsThings\Traits\SerializableTrait;

abstract class AbstractCollection implements IteratorAggregate, SerializableInterface, ArrayableInterface
{
    use SerializableTrait;

    protected array $collection = [];

    private string $collectionType;

    abstract protected function getCollectionType(): string;

    final public function __construct()
    {
        $this->collectionType = $this->getCollectionType();

        if (!class_exists($this->collectionType) && !interface_exists($this->collectionType)) {
            throw new InvalidCollectionTypeException($this->collectionType);
        }
    }

    final protected function getCollection(): array
    {
        return $this->collection;
    }

    public static function createFromArray(array $array): static
    {
        $collection = new static();

        foreach ($array as $value) {
            $collection->addToCollection($value);
        }

        return $collection;
    }

    final public function count(): int
    {
        return count($this->collection);
    }

    final public function getLast(): mixed
    {
        return end($this->collection) ?: null;
    }

    final public function pullFirst(): mixed
    {
        return array_shift($this->collection);
    }

    final public function pullLast(): mixed
    {
        return array_pop($this->collection);
    }

    public function addToCollection(mixed $collectionItem, mixed $key = null): self
    {
        $this->checkIfDoesMatchCollectionType($collectionItem);

        if (is_null($key)) {
            $this->collection[] = $collectionItem;
        } else {
            $this->collection[$key] = $collectionItem;
        }

        return $this;
    }

    private function checkIfDoesMatchCollectionType(mixed $collectionItem): void
    {
        if (!$collectionItem instanceof $this->collectionType) {
            throw new InvalidCollectionItemException(
                $this->collectionType,
                is_object($collectionItem)
                    ? get_class($collectionItem)
                    : gettype($collectionItem)
            );
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->collection);
    }

    final public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    final public function getFirst(): mixed
    {
        return reset($this->collection) ?: null;
    }

    public static function createFromAssocArray(array $array): self
    {
        $collection = new static();

        foreach ($array as $key => $value) {
            $collection->addToCollection($value, $key);
        }

        return $collection;
    }

    final public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->collection);
    }

    final public function clear(): void
    {
        $this->collection = [];
    }

    final public function getCollectionElements(): array
    {
        return $this->collection;
    }

    final public function forEach(Closure $closure): void
    {
        foreach ($this->collection as $key => $element) {
            $closure($element, $key);
        }
    }

    final protected function sort(Closure $closure): static
    {
        usort($this->collection, $closure);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->collection;
    }

    public function map(Closure $p): array
    {
        return array_map($p, $this->getCollection());
    }

    public function hasMoreThanOneElement(): bool
    {
        return $this->count() > 1;
    }
}
