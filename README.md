# Rapidez Login As Customer

Gives the possibility to an admin to login as a customer. Instead of the button from the Magento backend you've to go to `/login-as-customer` and fill in your admin user credentials and the email address of the customer.

## Installation

```bash
composer require rapidez/login-as-customer
```

> [!TIP]
> Install [rapidez/magento2-compadre](https://github.com/rapidez/magento2-compadre) to make the admin "Login As Customer" buttons work.

## Views

If you need to change the view you can publish it with:

```bash
php artisan vendor:publish --provider="Rapidez\LoginAsCustomer\LoginAsCustomerServiceProvider" --tag=views
```

## Notes

Currently this only works when two factor authentication is disabled! We recommend [MarkShust_DisableTwoFactorAuth](https://github.com/markshust/magento2-module-disabletwofactorauth) as it provides an option to disable 2FA for API token generation which is required for this package to work!

## License

GNU General Public License v3. Please see [License File](LICENSE) for more information.
