<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\URL\IndexURLRequest;
use App\Services\URL\IndexURLService;
use App\Services\URL\ShortenURLRequest;
use App\Services\URL\ShortenURLService;
use Exception;

class URLController
{
    private string $path;

    public function __construct()
    {
        if (empty($_ENV['PATH'])) {
            $this->path = 'http://localhost:8000/';
        } else {
            $this->path = $_ENV['PATH'];
        }
    }

    public function shorten(): Redirect
    {
        try {
            $bytes = random_bytes(6);
            $short = bin2hex($bytes);

            $longURL = $_POST["long_url"];
            $shortURL = $this->path . $short;
            $this->validateURL($longURL);

            if (empty($_SESSION["errors"])) {
                (new ShortenURLService())->execute(new ShortenURLRequest($longURL, $shortURL));
            }


        } catch (Exception $exception) {

            $_SESSION['errors'] = "Unexpected Error";

        }
        return new Redirect('/short');
    }


    public function redirect($vars)
    {
        $url = (new IndexURLService())->execute(new IndexURLRequest($this->path, $vars["short"]));

        if ($url !== null) {
            header('Location: ' . $url->getLongUrl());
        } else {
            header('Location: /short');
        }
    }


    private function validateURL(string $longURL)
    {
        if (filter_var($longURL, FILTER_VALIDATE_URL) === false) {
            $_SESSION["errors"] = "Website not valid";
        }
    }
}
