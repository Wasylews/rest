<?php

declare(strict_types=1);

namespace App\V1\Http\Model;


class CreateUserRequest extends UserRequest {

    protected $balance;

    public function getBalance(): float {
        return $this->balance;
    }

    public function setBalance(float $balance) {
        $this->balance = $balance;
    }

    function normalize(): array {
        return array_merge(
            parent::normalize(),
            [
                'balance' => $this->balance
            ]
        );
    }

    function denormalize(array $arr) {
        parent::denormalize($arr);
        $this->balance = $arr['balance'] ?? 0;
    }


}