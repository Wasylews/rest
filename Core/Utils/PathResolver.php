<?php

declare(strict_types=1);

namespace Core\Utils;


class PathResolver {

    private $baseDir;
    private $configDir;

    public function __construct() {
        $this->baseDir = __DIR__ . '/../..';
    }

    public function resolveBasePath(string $dir): string {
        return $this->baseDir . '/' . $dir;
    }

    public function setConfigDir(string $dir) {
        $this->configDir = $this->resolveBasePath($dir);
    }

    public function resolveConfigPath(string $configFile): string {
        return $this->configDir . '/' . $configFile;
    }
}