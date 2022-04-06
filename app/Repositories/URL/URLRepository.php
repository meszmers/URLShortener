<?php

namespace App\Repositories\URL;


use App\Models\URL;
use App\Services\URL\FetchLastURLRequest;
use App\Services\URL\IndexURLRequest;
use App\Services\URL\ShortenURLRequest;

interface URLRepository
{
    public function shorten(ShortenURLRequest $request): void;

    public function fetchLast(FetchLastURLRequest $request): array;

    public function index(IndexURLRequest $request): ?URL;
}