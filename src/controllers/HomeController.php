<?php

namespace App\controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response, $args): Response
    {
        $response->getBody()->write(
            $this->render('home/home.html.twig', ['args' => $args])
        );
        return $response;
    }
}