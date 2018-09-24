<?php

declare(strict_types=1);

namespace Core\Serialization\Encoder;


class XmlEncoder implements EncoderInterface {

    private $rootNodeName;

    /**
     * @var \DOMDocument $dom
    */
    private $dom;

    public function __construct(string $rootNode = 'response') {
        $this->rootNodeName = $rootNode;
    }

    /**
     * Generate from associative array xml dom like:
     * <response>
     *      <id>123></id>
     *      <firstName>John</firstName>
     *      <lastName>Snow</lastName>
     * </response>
     *
     * @param array $arr
     * @return string
     */
    function encode(array $arr): string {
        $this->dom = new \DOMDocument('', '');
        $this->dom->appendChild($this->encodeArray($this->rootNodeName, $arr));
        return $this->dom->saveXML($this->dom->firstChild);
    }

    private function encodeArray($rootName, array $arr) {
        $root = $this->dom->createElement($rootName);
        foreach ($arr as $name => $value) {
            if (is_array($value)) {
                $root->appendChild($this->encodeArray($name, $value));
            } else {
                $root->appendChild($this->dom->createElement($name, (string) $value));
            }
        }
        return $root;
    }

    /**
     * Collect xml dom into associative array
     * @param string $str
     * @return array
     */
    function decode(string $str): array {
        $this->dom = new \DOMDocument();
        $this->dom->preserveWhiteSpace = false;
        $this->dom->loadXML($str);
        $this->dom->normalizeDocument();

        // Valid DOM have only one root node
        return $this->decodeArray($this->dom->firstChild);
    }

    private function decodeArray(\DOMNode $rootNode): array {
        $result = [];
        /** @var \DOMNode $childNode */
        foreach ($rootNode->childNodes as $childNode) {
            if ($childNode->hasChildNodes() && $childNode->firstChild->nodeType !== XML_TEXT_NODE) {
                $result[$childNode->nodeName] = $this->decodeArray($childNode);
            } else {
                $result[$childNode->nodeName] = $childNode->nodeValue;
            }
        }
        return $result;
    }
}