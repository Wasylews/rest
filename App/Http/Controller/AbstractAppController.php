<?php

namespace App\Http\Controller;

abstract class AbstractAppController extends \Core\Http\AbstractController {

    /**
     * @var \Core\Serialization\Serializer
     */
    protected $serializer;

    public function __construct(\Core\Serialization\Serializer $serializer) {
        $this->serializer = $serializer;
    }

    protected function makeResponse($content, $format, int $code = \Core\Http\Response::HTTP_OK): \Core\Http\Response {
        try {
            $serializedContent = $this->serializer->serialize($content, $format);

            switch ($format) {
                case \Core\Serialization\Serializer::FORMAT_XML:
                    return new \Core\Http\XmlResponse($code, $serializedContent);
                case \Core\Serialization\Serializer::FORMAT_JSON:
                    return new \Core\Http\XmlResponse($code, $serializedContent);
                default:
                    return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST,
                        sprintf('Unknown format "%s"', $format));
            }
        } catch (\Core\Serialization\SerializationException $e) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}