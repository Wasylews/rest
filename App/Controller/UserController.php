<?php

declare(strict_types=1);

namespace App\Controller;

class UserController extends \Core\Http\AbstractController {

    private $service;
    private $serializer;

    public function __construct(\App\Service\UserService $service, \Core\Serialization\Serializer $serializer) {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    public function get(\Core\Http\Request $request): \Core\Http\Response {
        if (!$request->hasParameter('id')) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_OK,
                json_encode($this->service->getAll()));
        }

        $userId = intval($request->getParameter('id'));
        if ($userId != 0) {
            return new \Core\Http\XmlResponse(\Core\Http\Response::HTTP_OK, $this->service->get($userId));
        } else {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST,
                "Invalid user id");
        }
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $user = $this->serializer->deserialize($request->getBody(),
                \Core\Serialization\Serializer::FORMAT_XML, \App\Model\UserModel::class);
            $this->service->add($user);
        } catch (\Core\Serialization\SerializationException $e) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST,
                "User data must be specified");
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }
}