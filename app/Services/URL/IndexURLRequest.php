<?php

namespace App\Services\URL;

class IndexURLRequest
{
    private string $shortURL;

    public function __construct(string $shortURL)
    {
        $this->shortURL = $shortURL;

    }

    /**
     * @return string
     */
    public function getShortURL(): string
    {
        return $this->shortURL;
    }

}