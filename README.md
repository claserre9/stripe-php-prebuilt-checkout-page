# Stripe PHP Prebuilt Checkout Page

This project is an example PHP application that integrates [Stripe Checkout](https://stripe.com/docs/checkout/quickstart) using the `stripe-php` library and the Slim framework. It provides a small donation form where users can choose or enter an amount and are redirected to Stripe's prebuilt checkout page.

The frontend assets are managed with Webpack and Knockout.js while Twig is used for server-side templates.

## Requirements

- PHP 8.1 or newer
- Composer
- Node.js and npm

## Installation

1. **Clone the repository**
   ```bash
   git clone <repo-url>
   cd stripe-php-prebuilt-checkout-page
   ```
2. **Install PHP dependencies**
   ```bash
   composer install
   ```
3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

## Environment configuration

Create a `.env` or `.env.local` file at the project root and define at least the following variables:

```dotenv
STRIPE_SECRET_KEY=sk_test_your_secret_key
DOMAIN=http://localhost:8000
```

`STRIPE_SECRET_KEY` is your Stripe secret key. `DOMAIN` should match the base URL where the app is served so that Stripe can redirect back after payment.

## Building assets

Webpack is used to compile JavaScript and CSS located in `public/assets/` into the `public/dist/` directory.

- Development build (with source maps):
  ```bash
  npm run dev
  ```
- Watch for changes in development:
  ```bash
  npm run watch
  ```
- Production build (minified):
  ```bash
  npm run build
  ```

## Running the application

Serve the `public/` directory with PHP's built‑in server or your preferred web server:

```bash
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` to view the donation page. After submitting a donation amount, you will be redirected to Stripe Checkout. Upon completion you will return to `/payment/success` or `/payment/error`.

## Project structure

- `public/` – Front controller (`index.php`) and compiled assets
- `src/` – Controllers and middleware
- `templates/` – Twig templates
- `config/` – Dependency injection container configuration
- `webpack.config.js` – Webpack setup for assets

## Development notes

- The project uses Slim 4 and PHP‑DI for routing and dependency injection.
- Twig is used for templating. The base layout is `templates/layout.html.twig` and the donation form is located in `templates/home/home.html.twig`.
- `public/assets/js/home.js` contains a simple Knockout.js view model for the donation form.

Feel free to adapt this project for your own Stripe Checkout experiments.

