<?php

namespace Core\Di\Provider;


class RequestProvider implements DependencyProviderInterface {

    /**
     * @return \Core\Http\Request
     */
    public function get() {
        $request = new \Core\Http\Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $request->setBody(file_get_contents('php://input'));
        $request->setHeaders(getallheaders());
        return $request;
    }
}