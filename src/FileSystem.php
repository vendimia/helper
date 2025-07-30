<?php

namespace Vendimia\Helper;

use Vendimia\ObjectManager\ObjectManager;
use Vendimia\Logger\Logger;

/**
 * Helper classes for file system operations.
 */
class FileSystem
{
    /**
     * Creates a directory tree structure using a nested array.
     *
     * The first level should be the absolute path of the root directory, each
     * sublevel will be created inside and recursively.
     */
    public static function createDirectoryTree(array $tree)
    {
        // Si existe un logger, lo usamos
        $logger = null;
        if (class_exists(ObjectManager::class)) {
            $logger = ObjectManager::retrieve()->get(Logger::class);
        }

        foreach ($tree as $parent => $children) {
            foreach ($children as $key => $child) {
                // Si 'key' es un número, entonces $child es un string con
                // el nombre de un subdirectorio. Lo creamos prefijándolo
                // con $parent
                if (is_numeric($key)) {
                    $path = $parent . DIRECTORY_SEPARATOR . $child;

                    if (is_dir($path)) {
                        $logger?->notice("IGNORE $path");
                    } else {
                        $logger?->notice("MKDIR $path");
                        mkdir ($path, permissions: 0o755, recursive: true);
                    }
                } else {
                    $path = $parent . DIRECTORY_SEPARATOR . $key;
                    // Si es un string, entonces es un árbol
                    self::createDirectoryTree([$path => $child]);
                }

            }
        }
    }
}
