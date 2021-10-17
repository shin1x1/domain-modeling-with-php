<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class RecipientId
{
    public function __construct(private int $id = 0)
    {
    }
}