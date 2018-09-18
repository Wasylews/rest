<?php

declare(strict_types=1);

namespace Core\Serialization\Encoder;

/**
 * Base interface for converting array into string formats such as json or xml and vise versa.
*/
interface EncoderInterface {

    /**
     * Convert array to string of this encoder format.
     * @param array $arr associative array of some object
     * @return string format encoded string
     */
    function encode(array $arr): string;

    /**
     * Decode formatted string into associative array
     * @param string $str string of some format such as json or xml.
     * @return array associative array constructed of decoded string.
     */
    function decode(string $str): array;
}