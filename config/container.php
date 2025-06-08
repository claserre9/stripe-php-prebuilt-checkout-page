<?php


use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

$definitions = [
    DebugExtension::class =>DI\autowire(),
    FilesystemLoader::class => DI\autowire()->constructor(__DIR__ . "/../templates"),
    Environment::class => DI\autowire()->constructor(DI\get(FilesystemLoader::class))
        ->method('addExtension', DI\get(DebugExtension::class)),
];

return $definitions;