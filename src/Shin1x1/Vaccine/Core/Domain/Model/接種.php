<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class 接種
{
    public function __construct(
        private ワクチンロット番号 $ワクチンロット番号,
    ) {
    }

    public function getワクチンロット番号(): ワクチンロット番号
    {
        return $this->ワクチンロット番号;
    }
}