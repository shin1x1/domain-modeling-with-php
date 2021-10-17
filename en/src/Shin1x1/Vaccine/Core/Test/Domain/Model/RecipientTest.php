<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\InvalidOperationException;
use Shin1x1\Vaccine\Core\Domain\Model\Recipient;
use Shin1x1\Vaccine\Core\Domain\Model\RecipientId;
use Shin1x1\Vaccine\Core\Domain\Model\Reservation;
use Shin1x1\Vaccine\Core\Domain\Model\Vaccination;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationStatus;
use Shin1x1\Vaccine\Core\Domain\Model\ReservedDate;
use Shin1x1\Vaccine\Core\Domain\Model\VaccineLotNo;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;

final class RecipientTest extends TestCase
{
    /**
     * @test
     */
    public function new_()
    {
        $actual = new Recipient(new RecipientId());

        $expected = new Recipient(new RecipientId(), VaccinationStatus::Unreserved, reservation: null, vaccination: null);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function reserve()
    {
        $sut = new Recipient(new RecipientId());
        $reservation = new Reservation(new ReservedDate(Date::createFromString('2021-09-19')));
        $actual = $sut->reserve($reservation);

        $expected = new Recipient(new RecipientId(), VaccinationStatus::Reserved, reservation: $reservation, vaccination: null);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function reserve_error_status_is_reserved()
    {
        $this->expectException(InvalidOperationException::class);

        $reservation = new Reservation(new ReservedDate(Date::createFromString('2021-09-19')));
        $sut = new Recipient(new RecipientId(), VaccinationStatus::Reserved, reservation: $reservation, vaccination: null);
        $sut->reserve($reservation);
    }

    /**
     * @test
     */
    public function reserve_error_status_is_vaccined()
    {
        $this->expectException(InvalidOperationException::class);

        $reservation = new Reservation(new ReservedDate(Date::createFromString('2021-09-19')));
        $vaccination = new Vaccination(new VaccineLotNo('A12345'));
        $sut = new Recipient(new RecipientId(), VaccinationStatus::Vaccinated, reservation: $reservation, vaccination: $vaccination);
        $sut->reserve($reservation);
    }

    /**
     * @test
     */
    public function cancel()
    {
        $reservation = new Reservation(new ReservedDate(Date::createFromString('2021-09-19')));
        $sut = new Recipient(new RecipientId(), VaccinationStatus::Reserved, reservation: $reservation);
        $actual = $sut->cancel();

        $expected = new Recipient(new RecipientId(), VaccinationStatus::Unreserved, reservation: null, vaccination: null);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function vaccinate()
    {
        $reservation = new Reservation(new ReservedDate(Date::createFromString('2021-09-19')));
        $vaccination = new Vaccination(new VaccineLotNo('A12345'));

        $sut = new Recipient(new RecipientId(), VaccinationStatus::Reserved, reservation: $reservation);
        $actual = $sut->vaccinate($vaccination);

        $expected = new Recipient(new RecipientId(), VaccinationStatus::Vaccinated, reservation: $reservation, vaccination: $vaccination);
        $this->assertEquals($expected, $actual);
    }
}

