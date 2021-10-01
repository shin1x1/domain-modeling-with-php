<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class 接種券
{
    private function __construct(
        private 接種者Id $接種者Id,
        private 接種券番号 $接種券番号,
        private 自治体番号 $自治体番号,
    ) {
    }

    public function get接種者Id(): 接種者Id
    {
        return $this->接種者Id;
    }

    public function get接種券番号(): 接種券番号
    {
        return $this->接種券番号;
    }

    public function get自治体番号(): 自治体番号
    {
        return $this->自治体番号;
    }
}