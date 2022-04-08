<?php

namespace App\Services\URL;

use App\Models\URL;
use App\Repositories\URL\URLRepository;

class IndexURLService
{
    private URLRepository $URLRepository;

    public function __construct(URLRepository $URLRepository)
    {
        $this->URLRepository = $URLRepository;
    }

    public function execute(IndexURLRequest $request): ?URL
    {
        return $this->URLRepository->index($request);
    }
}