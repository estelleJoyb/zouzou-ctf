<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class apiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getCuteMessages(): array
    {
        $response = $this->client->request(
            'GET',
            'https://evilinsult.com/generate_insult.php?lang=fr&type=json'
        );

        return $response->toArray();
    }
}