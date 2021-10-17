<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\VaccineDate;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;

final class VaccinationDateTest extends TestCase
{
    /**
     * @test
     */
    public function createFromString(): void
    {
        $actual = VaccineDate::createFromString('2021-09-29', Date::createFromString('2021-09-22'));

        $this->assertSame('2021-09-29', $actual->toDateString());
    }

    /**
     * @test
     */
    public function createFromString_error_if_date_is_less_than_6day(): void
    {
        $this->expectException(PreconditionException::class);

        VaccineDate::createFromString(
            '2021-09-28',
            Date::createFromString('2021-09-22')
        );
    }

    /**
     * @test
     * @dataProvider dataProvider_createFromString_error_out_of_range
     */
    public function createFromString_error_out_of_range(string $dateString): void
    {
        $this->expectException(PreconditionException::class);

        VaccineDate::createFromString($dateString, Date::createFromString('2021-09-22'));
    }

    /**
     * @return iterable<string, array>
     */
    public function dataProvider_createFromString_error_out_of_range(): iterable
    {
        yield '7日未満' => [
            '2021-09-28',
        ];
        yield '31日以降' => [
            '2021-10-23',
        ];
    }
}

