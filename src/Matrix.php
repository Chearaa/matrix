<?php

namespace AksService\Matrix;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Matrix
{
    protected string $baseUrl;
    protected string $accessToken;

    public function __construct()
    {
        $this->baseUrl = config('matrix.baseUrl');
        $this->accessToken = config('matrix.accessToken');
    }

    public static function make(): self
    {
        return new static();
    }

    /**
     * @throws \Exception
     */
    public function get(string $endpoint, array $options = []): array
    {
        return $this->request('get', $endpoint, $options);
    }

    /**
     * @throws \Exception
     */
    protected function request(string $method, string $endpoint, array $options = []): array
    {
        $method = $this->cleanMethod($method);
        $endpoint = Str::startsWith($endpoint, '/') ? $endpoint : '/' . $endpoint;

        return json_decode(Http::$method($this->baseUrl . $endpoint, $options)->body(), true);
    }

    /**
     * @throws \Exception
     */
    protected function cleanMethod(string $method): string
    {
        $method = Str::lower($method);

        if (!in_array($method, $this->availableMethods())) {
            throw new \Exception('Bad method used: ' . $method);
        }

        return $method;
    }

    protected function availableMethods(): array
    {
        return ['get'];
    }

}
