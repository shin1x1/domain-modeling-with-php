<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\InvariantException;
use Shin1x1\Vaccine\Core\Domain\Model\VaccinationTicketNo;

final class VaccinationTicketCodeTest extends TestCase
{
    /**
     * @test
     */
    public function construct_(): void
    {
        $actual = new VaccinationTicketNo('1234567890');

        $this->assertSame('1234567890', $actual->toString());
    }

    /**
     * @test
     */
    public function construct_error(): void
    {
        $this->expectException(InvariantException::class);

        new VaccinationTicketNo('A234567890');
    }
}

