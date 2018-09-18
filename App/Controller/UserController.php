<?php

declare(strict_types=1);

namespace App\Controller;

class UserController extends \Core\Http\AbstractController {

    private $service;

    public function __construct(\App\Service\UserService $service) {
        $this->service = $service;
    }

    public function get(\Core\Http\Request $request): \Core\Http\Response {
        if (!$request->hasParameter('id')) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_OK,
                json_encode($this->service->getAll()));
        }

        $userId = intval($request->getParameter('id'));
        if ($userId != 0) {
            return new \Core\Http\JsonResponse(\Core\Http\Response::HTTP_OK, $this->service->get($userId));
        } else {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST,
                "Invalid user id");
        }
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        $body = $request->getBody();
        if ($body === null) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST,
                "User data must be specified");
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_NOT_IMPLEMENTED);
    }
}