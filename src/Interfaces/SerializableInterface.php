<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\Interfaces;

use JsonSerializable;

interface SerializableInterface extends JsonSerializable
{
    public function jsonSerialize(): array;
}
