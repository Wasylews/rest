<?php

declare(strict_types=1);

namespace App\V1\Http\Controller;


class UserController extends \App\Http\Controller\AbstractAppController {

    private $service;

    public function __construct(\App\V1\Service\UserService $service,
                                \Core\Serialization\Serializer $serializer) {
        $this->service = $service;
        parent::__construct($serializer);
    }

    public function get(\Core\Http\Request $request): \Core\Http\Response {
        if ($request->hasParameter('id')) {
            $userId = intval($request->getParameter('id'));
            $user = $this->service->get($userId);
            if ($user == null) {
                return $this->makeResponse('Unknown id', $request->getParameter('type'),
                    \Core\Http\Response::HTTP_BAD_REQUEST);
            }
            return $this->makeResponse($user, $request->getParameter('type'));
        } else {
            $users = new \Core\Serialization\Collections\SerializableArray($this->service->getAll());
            return $this->makeResponse($users, $request->getParameter('type'));
        }
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $userRequest = $this->serializer->deserialize($request->getBody(),
                $request->getParameter('type'),
                \App\V1\Http\Model\CreateUserRequest::class);
            $this->service->add($userRequest);
        } catch (\Exception $e) {
            return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                \Core\Http\Response::HTTP_BAD_REQUEST);
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }

    public function delete(\Core\Http\Request $request): \Core\Http\Response {
        $userId = intval($request->getParameter('id'));
        try {
            $this->service->delete($userId);
        } catch (\Exception $e) {
            return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                \Core\Http\Response::HTTP_BAD_REQUEST);
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }

    public function put(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $userId = intval($request->getParameter('id'));

            $userRequest = $this->serializer->deserialize($request->getBody(),
                $request->getParameter('type'),
                \App\V1\Http\Model\UserRequest::class);

            $this->service->update($userId, $userRequest);
        } catch (\Exception $e) {
            return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                \Core\Http\Response::HTTP_BAD_REQUEST);
        }

        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }
}