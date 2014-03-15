<?php

namespace Op3nvoice;

use Guzzle\Http;

abstract class Client
{
    const USER_AGENT = 'op3nvoice-php/0.0.1';

    protected $apiKey   = '';
    protected $client   = null;
    protected $request  = null;
    protected $response = null;
    protected $baseURI  = 'https://api-beta.op3nvoice.com/v1';

    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->apiKey = $key;
        $this->client = new Http\Client($this->baseURI);
        $this->client->setUserAgent($this::USER_AGENT . '/' . PHP_VERSION);
    }

    /**
     * @return bool
     */
    public function authenticate()
    {
        $request = $this->client->get('/');
        $request->addHeader('Authorization', $this->apiKey);
        $this->response =  $request->send();

        return $this->response->isSuccessful();
    }
}