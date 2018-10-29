<?php

declare(strict_types=1);

namespace App\Http\Model;

/**
 * Request model for add/update user
*/
class UserRequest implements \Core\Serialization\SerializableInterface {

    private $firstName;
    private $lastName;

    public function __construct(string $firstName, string $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->firstName = $arr['firstName'];
        $this->lastName = $arr['lastName'];
    }
}