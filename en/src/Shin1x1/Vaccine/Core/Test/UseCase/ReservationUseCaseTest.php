<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\UseCase;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\MunicipalityNumber;
use Shin1x1\Vaccine\Core\Domain\Model\Recipient;
use Shin1x1\Vaccine\Core\Domain\Model\RecipientId;
use Shin1x1\Vaccine\Core\Domain\Model\Reservation;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationStatus;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTiketCode;
use Shin1x1\Vaccine\Core\Domain\Model\VaccineDate;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientCommand;
use Shin1x1\Vaccine\Core\Domain\Port\RecipientQuery;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;
use Shin1x1\Vaccine\Core\UseCase\ReservationUseCase;

final class ReservationUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function run_()
    {
        $command = new class implements RecipientCommand {
            public ?Recipient $recipient = null;

            public function store(Recipient $recipient): void
            {
                $this->recipient = $recipient;
            }
        };

        $sut = new ReservationUseCase(
            new class implements RecipientQuery {
                public function findByVaccinationTicketCodeAndMunicipalityNumber(
                    VaccinationTiketCode $vaccinationTiketCode,
                    MunicipalityNumber   $municipalityNumber,
                ): ?Recipient
                {
                    return new Recipient(new RecipientId(1));
                }
            },
            $command,
        );

        $date = new VaccineDate(Date::createFromString('2021-09-27'));
        $sut->run(
            new VaccinationTiketCode('1234567890'),
            new MunicipalityNumber('123456'),
            $date,
        );

        $expected = new Recipient(
            new RecipientId(1),
            VaccinationStatus::Reserved,
            reservation: new Reservation($date),
            vaccination: null
        );
        $this->assertEquals($expected, $command->recipient);
    }

    /**
     * @test
     */
    public function run_error_recipient_not_found()
    {
        $this->expectException(PreconditionException::class);

        $sut = new ReservationUseCase(
            new class implements RecipientQuery {
                public function findByVaccinationTicketCodeAndMunicipalityNumber(
                    VaccinationTiketCode $vaccinationTiketCode,
                    MunicipalityNumber   $municipalityNumber,
                ): ?Recipient
                {
                    return null;
                }
            },
            new class implements RecipientCommand {
                public function store(Recipient $recipient): void
                {
                    throw new \BadMethodCallException();
                }
            }
        );

        $sut->run(
            new VaccinationTiketCode('1234567890'),
            new MunicipalityNumber('123456'),
            new VaccineDate(Date::createFromString('2021-09-27')),
        );
    }
}

