<?php

namespace App\Services\URL;

class ShortenURLRequest
{
    private string $longUrl;
    private string $hash;


    public function __construct(string $longUrl, string $hash)
    {
        $this->longUrl = $longUrl;

        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->longUrl;
    }
}