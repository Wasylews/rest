<?php

declare(strict_types=1);

namespace Core\Http;


abstract class AbstractController {

    public function get(Request $request): Response {
        return new Response(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function post(Request $request): Response {
        return new Response(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function put(Request $request): Response {
        return new Response(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function delete(Request $request): Response {
        return new Response(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}