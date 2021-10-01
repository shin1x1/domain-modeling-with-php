<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\UseCase;

use Shin1x1\Vaccine\Core\Domain\Exception\PreconditionException;
use Shin1x1\Vaccine\Core\Domain\Model\接種券番号;
use Shin1x1\Vaccine\Core\Domain\Model\自治体番号;
use Shin1x1\Vaccine\Core\Domain\Port\接種者Command;
use Shin1x1\Vaccine\Core\Domain\Port\接種者Query;

final class 予約キャンセルUseCase
{
    public function __construct(
        private 接種者Query $接種者Query,
        private 接種者Command $command,
    ) {
    }

    public function run(
        接種券番号 $接種券番号,
        自治体番号 $自治体番号,
    ): void {
        $接種者 = $this->接種者Query->findBy接種券番号And自治体番号($接種券番号, $自治体番号);
        if ($接種者 === null) {
            throw new PreconditionException('該当する接種者が存在しません');
        }

        $接種者 = $接種者->予約キャンセル();

        $this->command->store($接種者);
    }
}
