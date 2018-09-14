<?php

namespace Core\Http;


abstract class Controller {

    public abstract function get(Request $request): Response;
    public abstract function post(Request $request): Response;
    public abstract function put(Request $request): Response;
    public abstract function delete(Request $request): Response;
}