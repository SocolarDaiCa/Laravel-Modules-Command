# Laravel Modules Command

[![Latest Version on Packagist](https://img.shields.io/packagist/v/socoladaica/laravel-modules-command.svg?style=flat-square)](https://packagist.org/packages/socoladaica/laravel-modules-command)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/socoladaica/laravel-modules-command/Tests?label=tests)](https://github.com/socoladaica/laravel-modules-command/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/socoladaica/laravel-modules-command.svg?style=flat-square)](https://packagist.org/packages/socoladaica/laravel-modules-command)

Generate Command for Laravel Modules base on laravel Generate Command

## Installation

You can install the package via composer:

```bash
composer require socoladaica/laravel-modules-command
```

## Usage

```bash
php artisan cms:make:cast <name> <module>
php artisan cms:make:channel <name> <module> 
php artisan cms:make:component <name> <module> 
php artisan cms:make:controller <name> <module>
php artisan cms:make:event <name> <module>
php artisan cms:make:exception <name> <module> 
php artisan cms:make:factory <name> <module>
php artisan cms:make:job <name> <module>
php artisan cms:make:listener <name> <module> 
php artisan cms:make:mail <name> <module>
php artisan cms:make:middleware <name> <module> 
php artisan cms:make:migration <name> <module>
php artisan cms:make:model <name> <module>
php artisan cms:make:notification <name> <module>
php artisan cms:make:observer <name> <module>
php artisan cms:make:policy <name> <module>
php artisan cms:make:provider <name> <module>
php artisan cms:make:request <name> <module>
php artisan cms:make:resource <name> <module>
php artisan cms:make:rule <name> <module>
php artisan cms:make:seeder <name> <module>
php artisan cms:make:test <name> <module>
```

You can use all option like laravel command. Example:
```bash
php artisan cms:make:controller <name> --resource <module>
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Socola Dai Ca](https://github.com/SocolaDaiCa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
