<?php

declare(strict_types=1);

namespace Unit\ValueObjects;

use InvalidArgumentException;
use Libraries\CommonPhpProjectsThings\ValueObjects\DateTime;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testCreatesDateTimeFromValidString(): void
    {
        $date = new DateTime('2025-04-30 00:00:00');

        $this->assertSame('2025-04-30 00:00:00', $date->toString());
    }

    public function testThrowsExceptionOnInvalidDate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new DateTime('not-a-date');
    }
}
