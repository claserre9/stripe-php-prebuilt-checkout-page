<?php


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$definitions = [
    FilesystemLoader::class => DI\create()->constructor(__DIR__ . "/../templates"),
    Environment::class => DI\create()->constructor(DI\get(FilesystemLoader::class)),
];

return $definitions;