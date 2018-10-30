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
     * @\Doctrine\ORM\Mapping\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @\Doctrine\ORM\Mapping\Column(type="string")
     */
    private $firstName;

    /**
     * @\Doctrine\ORM\Mapping\Column(type="string")
     */
    private $lastName;

    /**
     * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="TransactionModel", mappedBy="from", cascade={"persist"})
    */
    private $outcomeTransactions;

    /**
     * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="TransactionModel", mappedBy="to", cascade={"persist"})
     */
    private $incomeTransactions;

    public function __construct(string $email, string $firstName, string $lastName) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->incomeTransactions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->outcomeTransactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getTransactions(): \Doctrine\Common\Collections\Collection {
        $transactions = array_merge($this->incomeTransactions->toArray(), $this->outcomeTransactions->toArray());
        return new \Doctrine\Common\Collections\ArrayCollection($transactions);
    }

    public function addTransaction(TransactionModel $transaction) {
        if ($transaction->getFrom() != null && $transaction->getFrom()->getId() == $this->id) {
            $this->outcomeTransactions->add($transaction);
        } else {
            $this->incomeTransactions->add($transaction);
        }
    }

    public function getBalance(): float {
        $sum = 0;
        foreach ($this->getTransactions() as $transaction) {
            if ($transaction->getFrom() != null && $transaction->getFrom()->getId() == $this->id) {
                $sum -= $transaction->getAmount();
            } else {
                $sum += $transaction->getAmount();
            }
        }
        return $sum;
    }

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'balance' => $this->getBalance()
        ];
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->id = intval($arr['id']);
        $this->email = $arr['email'];
        $this->firstName = $arr['firstName'];
        $this->lastName = $arr['lastName'];
    }
}