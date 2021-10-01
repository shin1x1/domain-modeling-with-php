<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Port;

use Shin1x1\Vaccine\Core\Domain\Model\接種券番号;
use Shin1x1\Vaccine\Core\Domain\Model\接種者;
use Shin1x1\Vaccine\Core\Domain\Model\自治体番号;

interface 接種者Query
{
    public function findBy接種券番号And自治体番号(
        接種券番号 $接種券番号,
        自治体番号 $自治体番号,
    ): ?接種者;
}
