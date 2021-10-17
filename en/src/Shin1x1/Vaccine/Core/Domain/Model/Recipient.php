<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

use Shin1x1\Vaccine\Core\Domain\Exception\InvalidOperationException;

final class Recipient
{
    public function __construct(
        private RecipientId       $id,
        private VaccinationStatus $vaccinationStatus = VaccinationStatus::Unreserved,
        private ?Reservation      $reservation = null,
        private ?Vaccination      $vaccination = null,
    )
    {
        if ($this->vaccinationStatus === VaccinationStatus::Unreserved) {
            assert($this->reservation === null);
            assert($this->vaccination === null);
        }
        if ($this->vaccinationStatus === VaccinationStatus::Reserved) {
            assert($this->reservation !== null);
            assert($this->vaccination === null);
        }
        if ($this->vaccinationStatus === VaccinationStatus::Vaccinated) {
            assert($this->reservation !== null);
            assert($this->vaccination !== null);
        }
    }

    public function reserve(Reservation $reservation): self
    {
        if ($this->vaccinationStatus !== VaccinationStatus::Unreserved) {
            throw new InvalidOperationException('Could not reserve in your status');
        }

        return new self(
            $this->id,
            VaccinationStatus::Reserved,
            $reservation,
        );
    }

    public function cancel(): self
    {
        if ($this->vaccinationStatus !== VaccinationStatus::Reserved) {
            throw new InvalidOperationException('Could not cancel in your status');
        }

        return new self(
            $this->id,
            VaccinationStatus::Unreserved,
        );
    }

    public function vaccinate(Vaccination $vaccination): self
    {
        if ($this->vaccinationStatus !== VaccinationStatus::Reserved) {
            throw new InvalidOperationException('Could not vaccaine in your status');
        }

        return new self(
            $this->id,
            VaccinationStatus::Vaccinated,
            $this->reservation,
            $vaccination,
        );
    }
}