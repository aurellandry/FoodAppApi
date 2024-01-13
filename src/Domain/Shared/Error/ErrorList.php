<?php

declare(strict_types=1);

namespace Domain\Shared\Error;

final class ErrorList implements \IteratorAggregate
{
    /** @var Error[] */
    private array $errors = [];

    public function addError(string $message, string $fieldName = null): void
    {
        $this->errors[] = new Error($fieldName, $message);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->errors);
    }

    public function isEmpty(): bool
    {
        return empty($this->errors);
    }
}
