<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\UseCase;

use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\MunicipalityNumber;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTiketCode;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientCommand;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientQuery;

final class CancelUseCase
{
    public function __construct(
        private RecipientQuery   $query,
        private RecipientCommand $command,
    )
    {
    }

    public function run(
        VaccinationTiketCode $vaccinationTiketCode,
        MunicipalityNumber   $municipalityNumber,
    ): void
    {
        $recipient = $this->query->findByVaccinationTicketCodeAndMunicipalityNumber($vaccinationTiketCode, $municipalityNumber);
        if ($recipient === null) {
            throw new PreconditionException('Recipient not found');
        }

        $recipient = $recipient->cancel();

        $this->command->store($recipient);
    }
}
