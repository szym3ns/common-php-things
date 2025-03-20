<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\ValueObjects;

use DateTime as PHPDateTime;
use InvalidArgumentException;

class DateTime extends AbstractValueObject
{
    public const string DEFAULT_FORMAT = 'Y-m-d H:i:s';
    public const string DEFAULT_VIEW_FORMAT = 'd.m.Y H:i';

    /**
     * @var PhpDateTime
     */
    protected mixed $value;

    public static function createFromPhpDateTime(PhpDateTime $dateTime): self
    {
        return new self(
            $dateTime->format(self::DEFAULT_FORMAT)
        );
    }

    public static function createFromTimestamp(int $timestamp): self
    {
        return self::createFromPhpDateTime(
            (new PhpDateTime())->setTimestamp($timestamp)
        );
    }

    public function __construct(string $value)
    {
        $unixTimeValue = strtotime($value);

        if (!$unixTimeValue) {
            throw new InvalidArgumentException(
                sprintf(
                    "Cannot convert: (%s) to %s",
                    $value,
                    self::class
                )
            );
        }

        $this->value =
            (new PhpDateTime())
                ->setTimestamp($unixTimeValue);
    }

    public function toString(string $format = self::DEFAULT_FORMAT): string
    {
        return $this->value->format($format);
    }

    public function __toString(): string
    {
        return $this->value->format(self::DEFAULT_FORMAT);
    }

    public function toTimestampInSeconds(): int
    {
        return $this->value->getTimestamp();
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    public static function createFromNow(): self
    {
        return self::createFromPhpDateTime(new PHPDateTime());
    }
}
