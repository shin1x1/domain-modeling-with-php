<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Port;

use Shin1x1\Vaccine\Core\Domain\Model\接種者;

interface 接種者Command
{
    public function store(接種者 $接種者): void;
}
