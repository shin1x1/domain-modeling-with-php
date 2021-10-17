<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

enum VaccinationStatus
{
    case Unreserved;
    case Reserved;
    case Vaccinated;
}