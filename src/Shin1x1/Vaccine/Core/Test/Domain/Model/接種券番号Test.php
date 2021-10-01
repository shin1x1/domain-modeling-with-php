<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Test\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shin1x1\Vaccine\Core\Domain\Exception\InvariantException;
use Shin1x1\Vaccine\Core\Domain\Model\接種券番号;

final class 接種券番号Test extends TestCase
{
    /**
     * @test
     */
    public function construct_(): void
    {
        $actual = new 接種券番号('1234567890');

        $this->assertSame('1234567890', $actual->toString());
    }

    /**
     * @test
     */
    public function construct_数字以外ならエラー(): void
    {
        $this->expectException(InvariantException::class);

        new 接種券番号('A234567890');
    }
}

