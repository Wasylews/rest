<?php

declare(strict_types=1);

namespace App\Model;


use Core\Serialization\SerializableInterface;

class UserModel implements SerializableInterface {

    private $id;
    private $firstName;
    private $lastName;

    public function __construct(int $id, string $firstName, string $lastName) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName
        ];
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->id = $arr['id'];
        $this->firstName = $arr['first_name'];
        $this->lastName = $arr['last_name'];
    }
}