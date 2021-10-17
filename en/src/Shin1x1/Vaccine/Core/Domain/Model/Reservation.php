<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class Reservation
{
    public function __construct(
        private ReservedDate $vaccineDate,
    )
    {
    }
}