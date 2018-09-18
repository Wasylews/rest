<?php

declare(strict_types=1);

namespace Core\Serialization;

/**
 * Base interface for data serialization.
*/
interface SerializableInterface {

    /**
     * Get array of data to serialize
     * @return array
     */
    function normalize(): array;

    /**
     * Fill object with deserialized data
     * @param array $arr
     */
    function denormalize(array $arr);
}