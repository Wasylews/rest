<?php

declare(strict_types=1);

namespace App\Model;


use Core\Serialization\SerializableInterface;

class UserModel implements SerializableInterface {

    private $id;
    private $firstName;
    private $lastName;

    public function __construct($id, $firstName, $lastName) {
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

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
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