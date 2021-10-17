<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Port;

use Shin1x1\Vaccine\Core\Domain\Model\Recipient;

interface RecipientCommand
{
    public function store(Recipient $recipient): void;
}
