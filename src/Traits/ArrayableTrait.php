<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\Traits;

use Libraries\CommonPhpProjectsThings\Interfaces\ArrayableInterface;
use Libraries\CommonPhpProjectsThings\ValueObjects\AbstractValueObject;
use Libraries\CommonPhpProjectsThings\ValueObjects\DateTime;

trait ArrayableTrait
{
    public function toArray(): array
    {
        $result = [];

        foreach ($this as $property => $value) {
            if ($value instanceof ArrayableInterface) {
                $result[$property] = $value->toArray();
            } elseif ($value instanceof AbstractValueObject) {
                $result[$property] = $value instanceof DateTime
                    ? $value->toString()
                    : $value->getValue();
            } elseif (is_object($value) && enum_exists($value::class)) {
                $result[$property] = $value->value;
            } elseif (is_object($value) && method_exists($value, 'toArray')) {
                $result[$property] = $value->toArray();
            } else {
                $result[$property] = $value;
            }
        }

        return $result;
    }
}
