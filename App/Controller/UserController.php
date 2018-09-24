<?php

declare(strict_types=1);

namespace App\Controller;

class UserController extends AbstractAppController {

    private $service;

    public function __construct(\App\Service\UserService $service, \Core\Serialization\Serializer $serializer) {
        $this->service = $service;
        parent::__construct($serializer);
    }

    public function get(\Core\Http\Request $request): \Core\Http\Response {
        if ($request->hasParameter('id')) {
            $userId = intval($request->getParameter('id'));
            $user = $this->service->get($userId);
            return $this->makeResponse($user, $request->getParameter('type'));
        } else {
            $users = $this->service->getAll();
            return $this->makeResponse($users, $request->getParameter('type'));
        }
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $user = $this->serializer->deserialize($request->getBody(),
                $request->getParameter('type'),
                \App\Model\UserModel::class);
            $this->service->add($user);
        } catch (\Core\Serialization\SerializationException $e) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }

    public function delete(\Core\Http\Request $request): \Core\Http\Response {
        $userId = intval($request->getParameter('id'));
        $this->service->delete($userId);
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }

    public function put(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $userId = intval($request->getParameter('id'));

            $newUser = $this->serializer->deserialize($request->getBody(),
                $request->getParameter('type'),
                \App\Model\UserModel::class);

            $this->service->update($userId, $newUser);
        } catch (\Core\Serialization\SerializationException $e) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST, $e->getMessage());
        }

        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }
}