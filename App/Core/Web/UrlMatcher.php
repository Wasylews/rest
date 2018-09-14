<?php

namespace Core\Web;


class UrlMatcher {

    /**
     * Match url by pattern and return url parameters on success
     * @param string $pattern
     * @param string $url
     * @return array|null
     */
    public static function match(string $pattern, string $url) {
        // At first escape special characters and add regex slashes
        $quotedPattern = '/' . str_replace(['/', '?', '&'], ['\/', '\?', '\&'], $pattern) . '/';
        // Then replace any {parameter} by (?P<parameter>\w+)
        $regexPattern = preg_replace('/\{(?P<parameter>\w+)\}/', '(?P<$1>\w+)', $quotedPattern);
        $matches = [];
        if (!preg_match($regexPattern, $url, $matches)) {
            return null;
        }
        // We need only named groups
        foreach($matches as $key => $match) {
            if (is_int($key)) {
                unset($matches[$key]);
            }
        }
        return $matches;
    }

}