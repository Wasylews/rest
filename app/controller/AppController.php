<?php

namespace app\controller;


class AppController extends \core\http\Controller {

    public function get(\core\http\Request $request): \core\http\Response {
        return new \core\http\Response(\core\http\Response::HTTP_OK,
            sprintf('Hello user #%d, you are on page %d',
                $request->getParameter('id'),
                $request->getParameter('page')
            ));
    }

    public function post(\core\http\Request $request): \core\http\Response {
        return new \core\http\Response(\core\http\Response::HTTP_FORBIDDEN, 'Not implemented yet');
    }

    public function put(\core\http\Request $request): \core\http\Response {
        return new \core\http\Response(\core\http\Response::HTTP_FORBIDDEN, 'Not implemented yet');
    }

    public function delete(\core\http\Request $request): \core\http\Response {
        return new \core\http\Response(\core\http\Response::HTTP_FORBIDDEN, 'Not implemented yet');
    }
}