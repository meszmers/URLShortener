<?php

namespace App\Services\URL;

use App\Repositories\URL\PDO_URLRepository;
use App\Repositories\URL\URLRepository;

class FetchLastURLService
{
    private URLRepository $URLRepository;

    public function __construct()
    {
        $this->URLRepository = new PDO_URLRepository;
    }

    public function execute(FetchLastURLRequest $request): array
    {
        return $this->URLRepository->fetchLast($request);
    }
}