<?php

declare(strict_types=1);

namespace Shin1x1\Vaccine\Core\Domain\Model;

use Shin1x1\Vaccine\Core\Domain\Exception\InvalidOperationException;

final class 接種状況
{
    public function __construct(
        private 接種状況Id $id,
        private 接種者Id $接種者Id,
        private 接種ステータス $接種ステータス = 接種ステータス::未予約,
        private ?予約接種日 $予約日時 = null,
        private ?ワクチンロット番号 $接種ロット番号 = null,
    ) {
        if ($this->接種ステータス === 接種ステータス::予約完了) {
            assert($this->予約日時 !== null);
        }
        if ($this->接種ステータス === 接種ステータス::接種完了) {
            assert($this->接種ロット番号 !== null);
        }
    }

    public function 予約完了(予約接種日 $datetime): self
    {
        if ($this->接種ステータス !== 接種ステータス::未予約) {
            throw new InvalidOperationException('現在のステータスで予約できません');
        }

        return new self(
            $this->id,
            $this->接種者Id,
            接種ステータス::予約完了,
            $datetime
        );
    }

    public function 予約キャンセル(): self
    {
        if ($this->接種ステータス !== 接種ステータス::予約完了) {
            throw new InvalidOperationException('現在のステータスで予約できません');
        }

        return new self(
            $this->id,
            $this->接種者Id,
            接種ステータス::未予約,
        );
    }

    public function 接種登録(ワクチンロット番号 $no): self
    {
        if ($this->接種ステータス !== 接種ステータス::予約完了) {
            throw new InvalidOperationException('現在のステータスで接種できません');
        }

        return new self(
            $this->id,
            $this->接種者Id,
            接種ステータス::接種登録,
            $this->予約日時,
            $no
        );
    }

    public function getId(): 接種状況Id
    {
        return $this->id;
    }

    public function get接種者Id(): 接種者Id
    {
        return $this->接種者Id;
    }

    public function get接種ステータス(): 接種ステータス
    {
        return $this->接種ステータス;
    }

    public function get予約日時(): ?予約接種日
    {
        return $this->予約日時;
    }

    public function get接種ロット番号(): ?ワクチンロット番号
    {
        return $this->接種ロット番号;
    }
}