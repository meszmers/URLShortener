<?php

namespace App\Services\URL;

use App\Repositories\URL\URLRepository;

class FetchLastURLService
{
    private URLRepository $URLRepository;

    public function __construct(URLRepository $URLRepository)
    {
        $this->URLRepository = $URLRepository;
    }

    public function execute(FetchLastURLRequest $request): array
    {
        return $this->URLRepository->fetchLast($request);
    }
}