# GithubApiBundle

A simple bridge between
[KnpLabs/php-github-api](https://github.com/KnpLabs/php-github-api) and
Symfony 3.

## Installation

Require the bundle with composer:

```
composer require maxikg/github-api-bundle
```

Now register the bundle:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Maxikg\GithubApiBundle\GithubApiBundle(),
    );
    // ...
}
```

## Configuration

The default configuration looks like:

```yaml
# app/config/config.yml
github_api:
    cache:
        enabled: false
        service: github.http.cache
    client: null
    enterprise_url: null
    authentication:
        type: none
        token: null
        client_id: null
        client_secret: null
        username: null
        password: null
```

 * `cache` configures the cached client.
    * `enabled` (boolean) allows to turn the cache on or off.
    * `service` (string) allows to specify a custom cache service. A
      cache must implements `Github\HttpClient\Cache\CacheInterface`
 * `client` configures client options. The allowed settings may vary
    from implementation to implementation. However, the defaults are:
    * `base_url` (string) specify the base API url (if you're using
      GitHub Enterprise you should use the `enterprise_url`
      configuration described below).
    * `user_agent` (string) specify the value for the `User-Agent`
      header.
      [GitHub likes to see your or your applications name here](https://developer.github.com/v3/#user-agent-required).
    * `timeout` (integer) specifies the connection time out in seconds.
    * `api_limit` (integer) unknown purpose.
    * `api_version` (string) the requested api version.
    * `cache_dir` (string) the cache directory. But I recommend to use
      the `cache` configuration section instead to avoid problems.
 * `enterprise_url` (string) configures a url for a GitHub Enterprise
   instance.
 * `authentication` configures the authentication with the api. You can
   use the GitHub.com API mostly without major restrictions without an
   authentication. GH Enterprise requires the authentication for nearly
   anything.
    * `type` (string) the authentication type:
      * `none` for disabled authentication.
      * `url_token` for appending an OAuth Token to the url by setting
        the `access_token` parameter.
      * `url_client_id` for appending your client's id and secret to
        the url by setting the `client_id` and `client_secret`
        parameter.
      * `http_password` for authenticating via HTTP header by setting
        your username and password. This won't work, if two factor
        authentication is enabled.
      * `http_token` for appending an OAuth Token to the HTTP headers.
    * `token` (string) specifies the OAuth Token. Only for `url_token`
      and `http_token` types.
    * `client_id` (string) specifies the client id. Only for
      `url_client_id` type.
    * `client_secret` (string) specifies the client secret. Only for
      `url_client_id` type.
    * `username` (string) specifies your username. Only for
      `http_password` type.
    * `password` (string) specifies your password. Only for
      `http_password` type.

But you aren't required to configure this Bundle. It will also work
with the defaults.

## Usage

You can obtain a instance of `Github\Client` by require the service
`github.client`.

For a more detailed instruction, please refer here:
https://github.com/KnpLabs/php-github-api/tree/1.6.0/doc

## Possibly upcoming features

 * Additional cache adapters:
   * Doctrine using entities
   * Doctrine Cache adapter using
     [doctrine/DoctrineCacheBundle](https://github.com/doctrine/DoctrineCacheBundle))
 * Multi client configuration
 * A better documentation in the `Resources/docs` folder
 * Compatibility checks against Symfony 2

## License

See [LICENSE.txt](./LICENSE.txt). Don't worry, it's the MIT license.
