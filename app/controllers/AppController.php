<?php

namespace app\controller;


class AppController extends \core\http\Controller {

    public function get(\core\http\Request $request) {
        return new \core\http\Response(200, 'Hello world');
    }

    public function post(\core\http\Request $request) {
    }

    public function put(\core\http\Request $request) {
    }

    public function delete(\core\http\Request $request) {
    }
}