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

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://github.com/rasouza"><img src="https://avatars3.githubusercontent.com/u/337906?v=4" width="100px;" alt=""/><br /><sub><b>Rodrigo Souza</b></sub></a><br /><a href="https://github.com/rasouza/diary-users/commits?author=rasouza" title="Documentation">📖</a> <a href="https://github.com/rasouza/diary-users/commits?author=rasouza" title="Code">💻</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!
