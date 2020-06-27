[![Build status](https://badge.buildkite.com/95c23aa7e478c2a528674bb1c9fa0122dd128b296906478e25.svg)](https://buildkite.com/rasouza/diary-users)
[![codecov](https://codecov.io/gh/rasouza/diary-users/branch/master/graph/badge.svg)](https://codecov.io/gh/rasouza/diary-users)
[![Maintainability](https://api.codeclimate.com/v1/badges/2f960a8fd83ef8919831/maintainability)](https://codeclimate.com/github/rasouza/diary-users/maintainability)

## About

Diary users is a microservice that handles user registration and integrates with [Hydra](https://github.com/ory/hydra) Identity Provider to manage access tokens inside the service mesh

## Installation

```
docker-compose up -d
cp .env.example .env

composer install
```

You must fill `.env` with `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET`. Check GitHub's [Creating an OAuth App](https://developer.github.com/apps/building-oauth-apps/creating-an-oauth-app/) documentation for reference

To run the application:
```
php artisan serve
```

## Testing
```
php artisan test
```

## License

The Diary Users component is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
