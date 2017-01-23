# laravel-generator
<!--
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
-->
Extend laravel generator command.

## Structure

```      
config/
src/
tests/
```


## Install

Via Composer

``` bash
$ composer require sands/laravel-generator
```

## Usage

``` bash
$ php artisan generate:scaffold Users
```

Alternatively,

``` bash
$ php artisan generate:controller Users --model=User
```

List all available commands

``` bash
$ php artisan | grep generate:
```

Configuration and Templates

``` bash
$ php artisan vendor:publish --tag=laravel-generator
```

Edit templates published to suit your project.


## Todo List

- [x] Controller
- [x] Model
- [x] Policy
- [x] Views (CRUD)
- [x] Request
- [x] Provider
- [x] Lang
- [x] Scaffold
- [ ] Form
- [ ] Migration
- [ ] Seeder
- [ ] Auto generate field from migrations
- [ ] Scaffold config
- [ ] Variable config
- [ ] Extend Generator

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email aminadha@gmail.com instead of using the issue tracker.

## Credits

- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sands/laravel-generator.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sands/laravel-generator/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sands/laravel-generator.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sands/laravel-generator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sands/laravel-generator.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sands/laravel-generator
[link-travis]: https://travis-ci.org/sands/laravel-generator
[link-scrutinizer]: https://scrutinizer-ci.com/g/sands/laravel-generator/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sands/laravel-generator
[link-downloads]: https://packagist.org/packages/sands/laravel-generator
[link-author]: https://github.com/aminadha
[link-contributors]: ../../contributors
