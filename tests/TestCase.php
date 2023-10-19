<?php

namespace Octopy\Flaravel\Tests;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Octopy\Flaravel\Adapter\LaravelHttp;
use Octopy\Flaravel\Auth\APIKey;
use Octopy\Flaravel\FlaravelServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @param  Application $app
     * @return string[]
     */
    public function getPackageProviders($app) : array
    {
        return [
            FlaravelServiceProvider::class,
        ];
    }

    /**
     * @param  array $data
     * @return void
     */
    protected function fake(array $data) : void
    {
        Http::preventStrayRequests();

        $data = collect($data)->flatMap(function ($res, $key) {
            if (! str($key)->contains('api.cloudflare.com')) {
                return [
                    'https://api.cloudflare.com/client/v4/' . trim($key, '/') => $res,
                ];
            }

            return [$key => $res];
        });

        Http::fake($data->toArray());
    }

    /**
     * @return APIKey
     */
    protected function getApiKey() : APIKey
    {
        return new APIKey('foo@example.com', '0123456789');
    }

    /**
     * @return LaravelHttp
     */
    protected function getHttpClient() : LaravelHttp
    {
        return new LaravelHttp(new APIKey('foo@example.com', '0123456789'));
    }

    /**
     * @param  string $name
     * @return array
     */
    protected function getJsonFixture(string $name) : array
    {
        $file = __DIR__ . '/Fixtures/' . $name;

        $this->assertFileExists($file);

        return json_decode(file_get_contents($file), true);
    }

    /**
     * @param  string $name
     * @return PromiseInterface
     */
    protected function getJsonFixtureResponse(string $name) : \GuzzleHttp\Promise\PromiseInterface
    {
        return Http::response($this->getJsonFixture($name));
    }
}