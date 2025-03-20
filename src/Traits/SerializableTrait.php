<?php

declare(strict_types=1);

namespace Libraries\CommonPhpProjectsThings\Traits;

trait SerializableTrait
{
    use ArrayableTrait;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
