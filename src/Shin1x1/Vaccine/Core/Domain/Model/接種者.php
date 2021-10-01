<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

use Shin1x1\Vaccine\Core\Domain\Exception\InvalidOperationException;

final class 接種者
{
    public function __construct(
        private 接種者Id $id,
        private 接種ステータス $接種ステータス = 接種ステータス::未予約,
        private ?予約 $予約 = null,
        private ?接種 $接種 = null,
    ) {
        if ($this->接種ステータス === 接種ステータス::未予約) {
            assert($this->予約 === null);
            assert($this->接種 === null);
        }
        if ($this->接種ステータス === 接種ステータス::予約完了) {
            assert($this->予約 !== null);
            assert($this->接種 === null);
        }
        if ($this->接種ステータス === 接種ステータス::接種完了) {
            assert($this->予約 !== null);
            assert($this->接種 !== null);
        }
    }

    public function 予約登録(予約 $予約): self
    {
        if ($this->接種ステータス !== 接種ステータス::未予約) {
            throw new InvalidOperationException('現在のステータスで予約できません');
        }

        return new self(
            $this->id,
            接種ステータス::予約完了,
            $予約,
        );
    }

    public function 予約キャンセル(): self
    {
        if ($this->接種ステータス !== 接種ステータス::予約完了) {
            throw new InvalidOperationException('現在のステータスで予約できません');
        }

        return new self(
            $this->id,
            接種ステータス::未予約,
        );
    }

    public function 接種登録(接種 $接種): self
    {
        if ($this->接種ステータス !== 接種ステータス::予約完了) {
            throw new InvalidOperationException('現在のステータスで接種できません');
        }

        return new self(
            $this->id,
            接種ステータス::接種完了,
            $this->予約,
            $接種,
        );
    }
}