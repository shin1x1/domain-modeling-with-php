<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\予約接種日;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;

final class 予約接種日Test extends TestCase
{
    /**
     * @test
     */
    public function createFromString(): void
    {
        $actual = 予約接種日::createFromString('2021-09-29', Date::createFromString('2021-09-22'));

        $this->assertSame('2021-09-29', $actual->toDateString());
    }

    /**
     * @test
     */
    public function createFromString_6日前ならエラー(): void
    {
        $this->expectException(PreconditionException::class);

        予約接種日::createFromString(
            '2021-09-28',
            Date::createFromString('2021-09-22')
        );
    }

    /**
     * @test
     * @dataProvider dataProvider_createFromString_範囲外ならエラー
     */
    public function createFromString_範囲外ならエラー(string $dateString): void
    {
        $this->expectException(PreconditionException::class);

        予約接種日::createFromString($dateString, Date::createFromString('2021-09-22'));
    }

    /**
     * @return iterable<string, array>
     */
    public function dataProvider_createFromString_範囲外ならエラー(): iterable
    {
        yield '7日未満' => [
            '2021-09-28',
        ];
        yield '31日以降' => [
            '2021-10-23',
        ];
    }
}

