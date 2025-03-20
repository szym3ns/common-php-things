<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\Collections\Exceptions;

use InvalidArgumentException;

final class InvalidCollectionTypeException extends InvalidArgumentException
{
    private const string MESSAGE_PATTERN = "Class/interface '%s' doesn't exists.";

    public function __construct(string $collectionType)
    {
        parent::__construct(
            sprintf(self::MESSAGE_PATTERN, $collectionType)
        );
    }
}
