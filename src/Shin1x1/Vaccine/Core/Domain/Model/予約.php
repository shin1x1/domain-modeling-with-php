<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

final class 予約
{
    public function __construct(
        private 予約接種日 $予約接種日,
    ) {
    }

    public function get予約接種日(): 予約接種日
    {
        return $this->予約接種日;
    }
}