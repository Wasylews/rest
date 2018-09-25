<?php

declare(strict_types=1);

namespace Core\Serialization;

/**
 * Base class for data serialization/deserialization.
*/
class Serializer {

    /**
     * Supported serialization formats
    */
    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';

    /**
     * @var Encoder\EncoderInterface[]
     */
    private $encoders = [];

    /**
     * @param string $format
     * @param Encoder\EncoderInterface $encoder
     * @throws SerializationException
     */
    public function addEncoder(string $format, $encoder) {
        if ($this->hasEncoder($format)) {
            throw new SerializationException(sprintf('Encoder for format "%s" already registered.', $format));
        }
        $this->encoders[$format] = $encoder;
    }

    public function hasEncoder(string $format): bool {
        return array_key_exists($format, $this->encoders);
    }

    /**
     * Serialize object to given format
     * @param $object
     * @param string $format
     * @return string
     * @throws SerializationException
     */
    public function serialize(SerializableInterface $object, string $format): string {
        if (!$this->hasEncoder($format)) {
            throw new SerializationException(sprintf('Cannot find encoder for format "%s".', $format));
        }
        try {
            return $this->encoders[$format]->encode($object->normalize());
        } catch (Encoder\EncodingException $e) {
            throw new SerializationException($e);
        }
    }

    /**
     * Deserialize string into object
     * @param string $str
     * @param string $format
     * @param string $intoClass class to construct from serializable string
     * @return mixed
     * @throws SerializationException
     */
    public function deserialize(string $str, string $format, string $intoClass) {
        if (!$this->hasEncoder($format)) {
            throw new SerializationException(sprintf('Cannot find encoder for format "%s".', $format));
        }

        /** @var SerializableInterface $class */
        $class = \Core\Utils\ReflectionUtils::newInstance($intoClass);
        if ($class === null) {
            throw new SerializationException(sprintf('Cannot create instance for class "%s".', $intoClass));
        }
        try {
            $class->denormalize($this->encoders[$format]->decode($str));
        } catch (Encoder\EncodingException $e) {
            throw new SerializationException($e);
        }
        return $class;
    }
}