<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class Vaccination
{
    public function __construct(
        private VaccineLotNo $vaccineTicketCode,
    )
    {
    }
}