<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Port;

use Shin1x1\Vaccine\Core\Domain\Model\MunicipalityNumber;
use Shin1x1\Vaccine\Core\Domain\Model\Recipient;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTiketCode;

interface RecipientQuery
{
    public function findByVaccinationTicketCodeAndMunicipalityNumber(
        VaccinationTiketCode $vaccinationTiketCode,
        MunicipalityNumber   $municipalityNumber,
    ): ?Recipient;
}
