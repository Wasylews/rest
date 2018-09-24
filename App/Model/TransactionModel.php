<?php

declare(strict_types=1);

namespace App\Model;


class TransactionModel implements \Core\Serialization\SerializableInterface {

    private $id;
    private $from;
    private $to;
    private $amount;

    public function __construct($id, $from, $to, $amount) {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
    }

    public function getId(): int {
        return $this->id;
    }


    public function setId(int $id) {
        $this->id = $id;
    }

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

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount) {
        $this->amount = $amount;
    }

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'id' => $this->id,
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
        $this->id = $arr['id'];
        $this->from = $arr['from'];
        $this->to = $arr['to'];
        $this->amount = doubleval($arr['amount']);
    }
}