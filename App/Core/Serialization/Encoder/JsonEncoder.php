<?php

declare(strict_types=1);

namespace Core\Serialization\Encoder;


class JsonEncoder implements EncoderInterface {

    function encode(array $arr): string {
        return json_encode($arr);
    }

    function decode(string $str): array {
        return json_decode($str, true);
    }
}