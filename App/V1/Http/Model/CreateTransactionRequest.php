<?php

declare(strict_types=1);

namespace App\V1\Http\Model;


class CreateTransactionRequest implements \Core\Serialization\SerializableInterface {

    private $from;
    private $to;
    private $amount;

    public function getFrom(): int {
        return $this->from;
    }

    public function setFrom(int $from) {
        $this->from = $from;
    }

    public function getTo(): int {
        return $this->to;
    }

    public function setTo(int $to) {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'amount' => $this->amount
        ];
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->from = $arr['from'];
        $this->to = $arr['to'];
        $this->amount = $arr['amount'];
    }
}