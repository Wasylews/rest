<?php

declare(strict_types=1);

namespace Core\Serialization\Encoder;


class JsonEncoder implements EncoderInterface {

    function encode(array $arr): string {
        $result = json_encode($arr);
        if ($result === false) {
            throw new EncodingException('Cannot encode array');
        }
        return $result;
    }

    function decode(string $str): array {
        $result = json_decode($str, true);
        if ($result === null) {
            throw new EncodingException('Cannot decode given string');
        }
        return $result;
    }
}