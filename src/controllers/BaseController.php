<?php

namespace App\controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class BaseController
{
    protected ?ContainerInterface $container;
    protected ?Environment $twig;

    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(?ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function getTwig(): ?Environment
    {
        return $this->twig;
    }

    public function setTwig(?Environment $twig): void
    {
        $this->twig = $twig;
    }
    public function __construct(?ContainerInterface $container, ?Environment $twig)
    {
        $this->container = $container;
        $this->twig = $twig;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function render( string $view, array $data = []): string
    {
        return $this->twig->render($view, $data);

    }



}