<?php

declare(strict_types=1);

namespace App\Http\Model;

/**
 * Request model for add/update user
*/
class UserRequest implements \Core\Serialization\SerializableInterface {

    private $email;
    private $firstName;
    private $lastName;

    public function __construct(string $email, string $firstName, string $lastName) {
        $this->email = $email;
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

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        return [
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->email = $arr['email'];
        $this->firstName = $arr['firstName'];
        $this->lastName = $arr['lastName'];
    }
}