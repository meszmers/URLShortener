<?php

namespace App\Services\URL;

use App\Models\URL;
use App\Repositories\URL\PDO_URLRepository;
use App\Repositories\URL\URLRepository;

class IndexURLService
{
    private URLRepository $URLRepository;

    public function __construct()
    {
        $this->URLRepository = new PDO_URLRepository;
    }

    public function execute(IndexURLRequest $request): ?URL
    {
        return $this->URLRepository->index($request);
    }
}