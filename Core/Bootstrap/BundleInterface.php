<?php

namespace Core\Bootstrap;

/**
 * Common interface for bundles - app components(or modules)
 * Bundles can be useful for different API versions or for splitting
 * app into few standalone components
*/
interface BundleInterface {

    function bindServices(\Core\Di\DependencyContainer $container);
    function initRoutes(\Core\Web\Router $router);
}