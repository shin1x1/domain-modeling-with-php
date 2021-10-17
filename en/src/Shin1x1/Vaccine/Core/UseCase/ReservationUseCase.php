<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\UseCase;

use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\MunicipalityNo;
use Shin1x1\Vaccine\Core\Domain\Model\Reservation;
use Shin1x1\Vaccine\Core\Domain\Model\ReservedDate;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTicketNo;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientCommand;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientQuery;

final class ReservationUseCase
{
    public function __construct(
        private RecipientQuery   $query,
        private RecipientCommand $command,
    )
    {
    }

    public function run(
        VaccinationTicketNo $vaccinationTiketCode,
        MunicipalityNo      $municipalityNumber,
        ReservedDate        $date,
    ): void
    {
        $recipient = $this->query->findByVaccinationTicketCodeAndMunicipalityNumber(
            $vaccinationTiketCode,
            $municipalityNumber,
        );
        if ($recipient === null) {
            throw new PreconditionException('Recipient not found');
        }

        $recipient = $recipient->reserve(new Reservation($date));

        $this->command->store($recipient);
    }
}
