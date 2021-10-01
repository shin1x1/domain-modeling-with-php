<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class 接種者Id
{
    public function __construct(private int $id = 0)
    {
    }

    public function toInt(): int
    {
        return $this->id;
    }
}