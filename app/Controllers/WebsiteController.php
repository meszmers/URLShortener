<?php

namespace App\Controllers;


use App\Services\URL\FetchLastURLRequest;
use App\Services\URL\FetchLastURLService;
use App\View;
use Psr\Container\ContainerInterface;

class WebsiteController
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(): View
    {
        return new View('Homepage.html');
    }

    public function short(): View
    {
        $displayURLCount = 3;
        $x = $this->container->get(FetchLastURLService::class)->execute(new FetchLastURLRequest($displayURLCount));

        return new View('Short.html', ['URLS' => $x, 'errors' => $_SESSION["errors"], 'count' => $displayURLCount]);
    }
}
