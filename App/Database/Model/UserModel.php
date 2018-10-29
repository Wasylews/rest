<?php

declare(strict_types=1);

namespace App\Database\Model;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="users")
 */
class UserModel extends \Core\Database\AbstractModel {

    /**
     * @\Doctrine\ORM\Mapping\Id
     * @\Doctrine\ORM\Mapping\GeneratedValue
     * @\Doctrine\ORM\Mapping\Column(type="integer")
    */
    private $id;

    /**
     * @\Doctrine\ORM\Mapping\Column(type="string")
     */
    private $firstName;

    /**
     * @\Doctrine\ORM\Mapping\Column(type="string")
     */
    private $lastName;

    /**
     * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="TransactionModel", mappedBy="transactions")
    */
    private $transactions;

    public function __construct($firstName, $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }


    public function getLastName(): string {
        return $this->lastName;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
    }

    public function getTransactions(): \Doctrine\Common\Collections\ArrayCollection {
        return $this->transactions;
    }

    public function addTransaction(TransactionModel $transaction) {
        $this->transactions->add($transaction);
    }

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->id = intval($arr['id']);
        $this->firstName = $arr['firstName'];
        $this->lastName = $arr['lastName'];
    }
}