<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;

final class ReservedDate
{
    public function __construct(private Date $date)
    {
    }

    public static function createFromString(string $dateString, Date $now): self
    {
        $date = Date::createFromString($dateString);
        if ($date->lessThan($now->addDay(7))
            || $date->graterThan($now->addDay(30))) {
            throw new PreconditionException();
        }

        return new self($date);
    }

    public function toDateString(): string
    {
        return $this->date->toDateString();
    }
}