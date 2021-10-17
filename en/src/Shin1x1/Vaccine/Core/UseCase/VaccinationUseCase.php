<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\UseCase;

use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\MunicipalityNo;
use Shin1x1\Vaccine\Core\Domain\Model\Vaccination;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTicketNo;
use Shin1x1\Vaccine\Core\Domain\Model\VaccineLotNo;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientCommand;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientQuery;

final class VaccinationUseCase
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
        VaccineLotNo        $no,
    ): void
    {
        $recipient = $this->query->findByVaccinationTicketCodeAndMunicipalityNumber(
            $vaccinationTiketCode,
            $municipalityNumber,
        );
        if ($recipient === null) {
            throw new PreconditionException('Recipient not found');
        }

        $recipient = $recipient->vaccinate(new Vaccination($no));

        $this->command->store($recipient);
    }
}
