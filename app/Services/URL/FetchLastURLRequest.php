<?php

namespace App\Services\URL;

class FetchLastURLRequest {
    private string $number;


    public function __construct(string $number)
    {
        $this->number = $number;

    }


    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }
}