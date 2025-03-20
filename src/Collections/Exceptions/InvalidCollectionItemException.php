<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\Collections\Exceptions;

use InvalidArgumentException;

final class InvalidCollectionItemException extends InvalidArgumentException
{
    private const string MESSAGE_PATTERN = 'Collection item must be type of %s. Given: %s';

    public function __construct(string $collectionType, string $givenType)
    {
        parent::__construct(
            sprintf(self::MESSAGE_PATTERN, $collectionType, $givenType)
        );
    }
}
