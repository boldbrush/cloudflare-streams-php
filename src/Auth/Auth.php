<?php

namespace BoldBrush\Cloudflare\API\Auth;

class Auth
{
    protected $account;

    protected $apiKey;

    protected $email;

    public function __construct($account, $apiKey, $email)
    {
        $this->account = strval($account);
        $this->apiKey = strval($apiKey);
        $this->email = strval($email);
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHeaders()
    {
        if ($this->getEmail() === 'api_token') {
            return [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ];
        }

        return [
            'X-Auth-Email' => $this->getEmail(),
            'X-Auth-Key' => $this->getApiKey(),
        ];
    }
}
