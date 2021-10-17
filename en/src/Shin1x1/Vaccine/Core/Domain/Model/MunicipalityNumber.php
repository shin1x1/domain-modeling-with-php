<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

use Shin1x1\Vaccine\Core\Domain\Exception\InvariantException;

final class MunicipalityNumber
{
    public function __construct(private string $code)
    {
        if (preg_match('/\A[0-9]{6}\z/', $code) !== 1) {
            throw new InvariantException('Invalid code:' . $code);
        }
    }

    public function toString(): string
    {
        return $this->code;
    }
}