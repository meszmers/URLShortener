<?php

namespace App\Services\URL;

use App\Repositories\URL\URLRepository;

class ShortenURLService
{

    private URLRepository $URLRepository;

    public function __construct(URLRepository $URLRepository)
    {
        $this->URLRepository = $URLRepository;
    }

    public function execute(ShortenURLRequest $request): void
    {
        $this->URLRepository->shorten($request);
    }
}