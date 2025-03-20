<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\ValueObjects;

final class Date extends DateTime
{
    public const string DEFAULT_FORMAT = 'Y-m-d';
    public const string DEFAULT_VIEW_FORMAT = 'd.m.Y';

    public function toString(string $format = self::DEFAULT_FORMAT): string
    {
        return parent::toString($format);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
