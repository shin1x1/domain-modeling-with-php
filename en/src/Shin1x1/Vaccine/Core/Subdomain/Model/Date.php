<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Subdomain\Model;

use Cake\Chronos\Date as ChronosDate;

final class Date
{
    private function __construct(
        private ChronosDate $chronos
    ) {
    }

    public static function now(): self
    {
        return new self(ChronosDate::now());
    }

    public static function createFromString(string $dateTime): self
    {
        return new self(ChronosDate::createFromFormat('Y-m-d', $dateTime));
    }

    public function graterThan(self $other): bool
    {
        return $this->chronos->greaterThan($other->chronos);
    }

    public function lessThan(self $other): bool
    {
        return $this->chronos->lessThan($other->chronos);
    }

    public function addDay(int $day): self
    {
        return new self($this->chronos->addDay($day));
    }

    public function toDateString(): string
    {
        return $this->chronos->toDateString();
    }
}
