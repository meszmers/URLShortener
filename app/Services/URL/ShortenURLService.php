<?php

namespace App\Services\URL;

use App\Repositories\URL\PDO_URLRepository;
use App\Repositories\URL\URLRepository;

class ShortenURLService
{

    private URLRepository $URLRepository;

    public function __construct()
    {
        $this->URLRepository = new PDO_URLRepository;
    }

    public function execute(ShortenURLRequest $request): void
    {
        $this->URLRepository->shorten($request);
    }
}