<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\UseCase;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\予約;
use Shin1x1\Vaccine\Core\Domain\Model\予約接種日;
use Shin1x1\Vaccine\Core\Domain\Model\接種ステータス;
use Shin1x1\Vaccine\Core\Domain\Model\接種券番号;
use Shin1x1\Vaccine\Core\Domain\Model\接種者;
use Shin1x1\Vaccine\Core\Domain\Model\接種者Id;
use Shin1x1\Vaccine\Core\Domain\Model\自治体番号;
use Shin1x1\Vaccine\Core\Domain\Port\接種者Command;
use Shin1x1\Vaccine\Core\Domain\Port\接種者Query;
use Shin1x1\Vaccine\Core\Subdomain\Model\Date;
use Shin1x1\Vaccine\Core\UseCase\予約登録UseCase;

final class 予約UseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function run_()
    {
        $command = new class implements 接種者Command {
            public ?接種者 $接種者 = null;

            public function store(接種者 $接種者): void
            {
                $this->接種者 = $接種者;
            }
        };

        $sut = new 予約登録UseCase(
            new class implements 接種者Query {
                public function findBy接種券番号And自治体番号(接種券番号 $接種券番号, 自治体番号 $自治体番号,): ?接種者
                {
                    return new 接種者(new 接種者Id(1));
                }
            },
            $command,
        );

        $date = new 予約接種日(Date::createFromString('2021-09-27'));
        $sut->run(
            new 接種券番号('1234567890'),
            new 自治体番号('123456'),
            $date,
        );

        $expected = new 接種者(
            new 接種者Id(1),
            接種ステータス::予約完了,
            予約: new 予約($date),
            接種: null
        );
        $this->assertEquals($expected, $command->接種者);
    }

    /**
     * @test
     */
    public function run_接種券番号と自治体番号にマッチする接種者がいない場合はエラー()
    {
        $this->expectException(PreconditionException::class);

        $sut = new 予約登録UseCase(
            new class implements 接種者Query {
                public function findBy接種券番号And自治体番号(接種券番号 $接種券番号, 自治体番号 $自治体番号,): ?接種者
                {
                    return null;
                }
            },
            new class implements 接種者Command {
                public function store(接種者 $接種者): void
                {
                    throw new \BadMethodCallException();
                }
            }
        );

        $sut->run(
            new 接種券番号('1234567890'),
            new 自治体番号('123456'),
            new 予約接種日(Date::createFromString('2021-09-27')),
        );
    }
}

