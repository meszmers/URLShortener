<?php

namespace App\Services\URL;

class ShortenURLRequest
{
    private string $longUrl;
    private string $shortUrl;

    public function __construct(string $longUrl, string $shortUrl)
    {
        $this->longUrl = $longUrl;
        $this->shortUrl = $shortUrl;
    }

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->longUrl;
    }
}