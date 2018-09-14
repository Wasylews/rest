<?php

namespace core\http;


abstract class Controller {

    public abstract function get(Request $request);
    public abstract function post(Request $request);
    public abstract function put(Request $request);
    public abstract function delete(Request $request);
}