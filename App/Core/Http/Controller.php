<?php

declare(strict_types=1);

namespace Core\Http;


interface Controller {

    public function get(Request $request): Response;
    public function post(Request $request): Response;
    public function put(Request $request): Response;
    public function delete(Request $request): Response;
}