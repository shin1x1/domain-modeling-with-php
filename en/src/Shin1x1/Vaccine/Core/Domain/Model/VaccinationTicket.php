<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class VaccinationTicket
{
    private function __construct(
        private RecipientId         $recipientId,
        private VaccinationTicketNo $vaccinationTiketCode,
        private MunicipalityNo      $municipalityNumber,
    )
    {
    }
}