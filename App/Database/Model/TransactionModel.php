<?php

declare(strict_types=1);

namespace App\Database\Model;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="transactions")
 */
class TransactionModel extends \Core\Database\AbstractModel {

    /**
     * @\Doctrine\ORM\Mapping\Id
     * @\Doctrine\ORM\Mapping\GeneratedValue
     * @\Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $id;

    /**
     * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="UserModel", inversedBy="transactions")
     * @\Doctrine\ORM\Mapping\JoinColumn(name="from_id", referencedColumnName="id")
     */
    private $from;

    /**
     * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="UserModel", inversedBy="transactions")
     * @\Doctrine\ORM\Mapping\JoinColumn(name="to_id", referencedColumnName="id")
     */
    private $to;

    /**
     * @\Doctrine\ORM\Mapping\Column(type="float")
     */
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

    public function getFrom(): UserModel {
        return $this->from;
    }

    public function setFrom(UserModel $from) {
        $this->from = $from;
    }

    public function getTo(): UserModel {
        return $this->to;
    }

    public function setTo(UserModel $to) {
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