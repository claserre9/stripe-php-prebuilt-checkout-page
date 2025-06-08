<?php

namespace App\middlewares;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        session_start();
        if (!isset($_SESSION['USER'])) {
            $response = $this->responseFactory->createResponse(401);
            $response->getBody()->write(json_encode(['error' => 'User not logged in']));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $handler->handle($request);
    }
}