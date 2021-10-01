<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\InvalidOperationException;
use Shin1x1\Vaccine\Core\Domain\Model\ワクチンロット番号;
use Shin1x1\Vaccine\Core\Domain\Model\予約;
use Shin1x1\Vaccine\Core\Domain\Model\予約接種日;
use Shin1x1\Vaccine\Core\Domain\Model\接種;
use Shin1x1\Vaccine\Core\Domain\Model\接種ステータス;
use Shin1x1\Vaccine\Core\Domain\Model\接種者;
use Shin1x1\Vaccine\Core\Domain\Model\接種者Id;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;

final class 接種者Test extends TestCase
{
    /**
     * @test
     */
    public function new_()
    {
        $actual = new 接種者(new 接種者Id());

        $expected = new 接種者(new 接種者Id(), 接種ステータス::未予約, 予約: null, 接種: null);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 予約()
    {
        $sut = new 接種者(new 接種者Id());
        $reservation = new 予約(new 予約接種日(Date::createFromString('2021-09-19')));
        $actual = $sut->予約登録($reservation);

        $expected = new 接種者(new 接種者Id(), 接種ステータス::予約完了, 予約: $reservation, 接種: null);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 予約エラー_予約完了時に予約完了を実行()
    {
        $this->expectException(InvalidOperationException::class);

        $reservation = new 予約(new 予約接種日(Date::createFromString('2021-09-19')));
        $sut = new 接種者(new 接種者Id(), 接種ステータス::予約完了, 予約: $reservation, 接種: null);
        $sut->予約登録($reservation);
    }

    /**
     * @test
     */
    public function 予約完了エラー_接種登録時に予約完了を実行()
    {
        $this->expectException(InvalidOperationException::class);

        $reservation = new 予約(new 予約接種日(Date::createFromString('2021-09-19')));
        $vaccination = new 接種(new ワクチンロット番号('A12345'));
        $sut = new 接種者(new 接種者Id(), 接種ステータス::接種完了, 予約: $reservation, 接種: $vaccination);
        $sut->予約登録($reservation);
    }

    /**
     * @test
     */
    public function 予約キャンセル()
    {
        $reservation = new 予約(new 予約接種日(Date::createFromString('2021-09-19')));
        $sut = new 接種者(new 接種者Id(), 接種ステータス::予約完了, 予約: $reservation);
        $actual = $sut->予約キャンセル();

        $expected = new 接種者(new 接種者Id(), 接種ステータス::未予約, 予約: null, 接種: null);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 接種登録()
    {
        $reservation = new 予約(new 予約接種日(Date::createFromString('2021-09-19')));
        $vaccination = new 接種(new ワクチンロット番号('A12345'));

        $sut = new 接種者(new 接種者Id(), 接種ステータス::予約完了, 予約: $reservation);
        $actual = $sut->接種登録($vaccination);

        $expected = new 接種者(new 接種者Id(), 接種ステータス::接種完了, 予約: $reservation, 接種: $vaccination);
        $this->assertEquals($expected, $actual);
    }
}

