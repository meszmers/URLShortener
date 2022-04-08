<?php

namespace App\Services\URL;

class IndexURLRequest
{


    private string $hash;

    public function __construct(string $hash)
    {

        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

}