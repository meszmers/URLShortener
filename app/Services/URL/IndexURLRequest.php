<?php

namespace App\Services\URL;

class IndexURLRequest
{
    private string $shortURL;
    private string $path;

    public function __construct(string $path, string $shortURL)
    {
        $this->shortURL = $shortURL;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getShortURL(): string
    {
        return $this->shortURL;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}