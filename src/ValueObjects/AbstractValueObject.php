<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\ValueObjects;

use Stringable;

abstract class AbstractValueObject implements Stringable
{
    protected mixed $value;

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
