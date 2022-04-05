<?php

namespace App\Models;

class URL
{
    private int $id;
    private string $longUrl;
    private string $shortUrl;

    public function __construct(int $id, string $longUrl, string $shortUrl)
    {
        $this->id = $id;
        $this->longUrl = $longUrl;
        $this->shortUrl = $shortUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->longUrl;
    }

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

}