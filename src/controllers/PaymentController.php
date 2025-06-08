<?php

namespace App\controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Stripe\StripeClient;

class PaymentController extends BaseController
{
    public function donate(Request $request, Response $response, $args)
    {
        // Handle POST request from the donation form
        if ($request->getMethod() === 'POST') {
            // Retrieve the donation amount
            $parsedBody = $request->getParsedBody();
            $amount = isset($parsedBody['amount']) ? (float)$parsedBody['amount'] : 0;

            if ($amount <= 0) {
                $response->getBody()->write('Invalid donation amount.');
                return $response->withStatus(400); // Bad request
            }

            // Initialize Stripe client
            $stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];
            $domainUrl = $_ENV['DOMAIN'];
            $stripe = new StripeClient($stripeSecretKey);

            try {
                // Create Stripe Checkout Session
                $checkoutSession = $stripe->checkout->sessions->create([
                    'success_url' => $domainUrl . '/payment/success?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => $domainUrl . '/payment/error',
                    'mode' => 'payment',
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Donation',
                            ],
                            'unit_amount' => $amount * 100,
                        ],
                        'quantity' => 1,
                    ]],
                ]);


                return $response
                    ->withHeader('Location', $checkoutSession->url)
                    ->withStatus(303);
            } catch (\Exception $e) {

                $errorMessage = $e->getMessage();
                $response->getBody()->write("Error creating Stripe Checkout Session: $errorMessage");
                return $response->withStatus(500);
            }
        }

        return $response->withStatus(405);
    }

    public function success(Request $request, Response $response, $args): Response|ResponseInterface
    {
        $session_id = $request->getQueryParams()['session_id'] ?? null;

        if ($session_id) {
            // Logic to retrieve and verify the session using Stripe API
            $stripe = new StripeClient($_ENV['STRIPE_SECRET_KEY']);
            try {
                $session = $stripe->checkout->sessions->retrieve($session_id);

                $html = "<h1>Payment Successful</h1>";
                $html .= "<p>Thank you! Your donation has been received.</p>";
                $response->getBody()->write($html);

                return $response->withStatus(200);
            } catch (\Exception $e) {
                $response->getBody()->write("<h1>Error</h1><p>Unable to verify payment session.</p>");
                return $response->withStatus(500);
            }
        }

        $response->getBody()->write("<h1>Payment Successful</h1><p>Thank you for your donation!</p>");
        return $response->withStatus(200);
    }

    public function error(Request $request, Response $response, $args): Response|ResponseInterface
    {
        $html = "<h1>Payment Canceled</h1>";
        $html .= "<p>Your payment was canceled. Please try again if you wish to donate.</p>";
        $response->getBody()->write($html);

        return $response->withStatus(200);
    }



}