<?php

declare(strict_types=1);

namespace App\Di\Provider;


class PathResolverProvider implements \Core\Di\Provider\DependencyProviderInterface {

    public function get() {
        $pathResolver = new \Core\Utils\PathResolver();
        $pathResolver->setConfigDir('App/Config');
        return $pathResolver;
    }
}