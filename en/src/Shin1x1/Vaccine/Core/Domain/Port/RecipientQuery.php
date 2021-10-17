<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Port;

use Shin1x1\Vaccine\Core\Domain\Model\MunicipalityNo;
use Shin1x1\Vaccine\Core\Domain\Model\Recipient;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTicketNo;

interface RecipientQuery
{
    public function findByVaccinationTicketCodeAndMunicipalityNumber(
        VaccinationTicketNo $vaccinationTiketCode,
        MunicipalityNo      $municipalityNumber,
    ): ?Recipient;
}
