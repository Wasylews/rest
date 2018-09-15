<?php

declare(strict_types=1);

namespace App\Controller;


class AppController implements \Core\Http\Controller {

    public function get(\Core\Http\Request $request): \Core\Http\Response {
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK,
            sprintf('Hello, user #%d, you are on page %d',
                $request->getParameter('id'),
                $request->getParameter('page')
            ));
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        return new \Core\Http\Response(\Core\Http\Response::HTTP_FORBIDDEN, 'Not implemented yet');
    }

    public function put(\Core\Http\Request $request): \Core\Http\Response {
        return new \Core\Http\Response(\Core\Http\Response::HTTP_FORBIDDEN, 'Not implemented yet');
    }

    public function delete(\Core\Http\Request $request): \Core\Http\Response {
        return new \Core\Http\Response(\Core\Http\Response::HTTP_FORBIDDEN, 'Not implemented yet');
    }
}