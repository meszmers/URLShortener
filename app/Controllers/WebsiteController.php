<?php

namespace App\Controllers;


use App\Services\URL\FetchLastURLService;
use App\View;

class WebsiteController
{
    public function index(): View
    {
        return new View('Homepage.html');
    }

    public function short(): View
    {
        $shortens = 3;
        $x = (new FetchLastURLService())->execute($shortens);

        return new View('Short.html', ['URLS' => $x, 'errors' => $_SESSION["errors"], 'count' => $shortens]);
    }
}
