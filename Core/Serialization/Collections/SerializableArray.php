<?php

declare(strict_types=1);

namespace Core\Serialization\Collections;


class SerializableArray implements \Core\Serialization\SerializableInterface {

    private $items;

    public function __construct(array $items) {
        $this->items = $items;
    }

    public function __get(int $i) {
        return $this->items[$i];
    }

    public function __set(int $i, $value) {
        $this->items[$i] = $value;
    }

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array {
        $result = [];
        foreach ($this->items as $item) {
            array_push($result, $item->normalize());
        }
        return $result;
    }

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr) {
        $this->items = $arr;
    }
}