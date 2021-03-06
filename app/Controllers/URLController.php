<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\URL\IndexURLRequest;
use App\Services\URL\IndexURLService;
use App\Services\URL\ShortenURLRequest;
use App\Services\URL\ShortenURLService;
use Exception;
use Psr\Container\ContainerInterface;

class URLController
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function shorten(): Redirect
    {
        $longURL = $_POST["long_url"];
        $hash = $this->generateHash();


        if($this->validateURL($longURL)) {
            $_SESSION["errors"] = "Website not valid";
        }


        if (empty($_SESSION["errors"])) {
                $this->container->get(ShortenURLService::class)->execute(new ShortenURLRequest($longURL, $hash));
        }

        return new Redirect('/short');
    }


    public function redirect($vars)
    {

        $url = $this->container->get(IndexURLService::class)->execute(new IndexURLRequest($vars["short"]));

        if ($url !== null) {
            header('Location: ' . $url->getLongUrl());
        } else {
            header('Location: /short');
        }
    }


    public function validateURL(string $longURL): bool
    {
        if (filter_var($longURL, FILTER_VALIDATE_URL) === false) {
            return true;
        }
        return false;
    }

    public function generateHash(): ?string {
        try {
            $bytes = random_bytes(6);
            return bin2hex($bytes);
        } catch (Exception $e) {
            $_SESSION['errors'] = 'Unexpected Error';
            return null;
        }

    }
}
