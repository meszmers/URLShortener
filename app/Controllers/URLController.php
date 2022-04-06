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

    private string $path = 'http://localhost:8000/';

    public function shorten()
    {
        try {
            $bytes = random_bytes(6);
            $short = bin2hex($bytes);

        } catch (Exception $exception) {
            echo "Bytes Exception: " . $exception->getMessage();
            die;
        }

        $longURL = $_POST["long_url"];
        $shortURL = $this->path . $short;
        $this->validateURL($longURL);

        if (empty($_SESSION["errors"])) {
            (new ShortenURLService())->execute(new ShortenURLRequest($longURL, $shortURL));
        }
        return new Redirect('/short');
    }


    public function redirect($vars)
    {
        $url = (new IndexURLService())->execute(new IndexURLRequest($this->path, $vars["short"]));

        if ($url !== null) {
            header('Location: ' . $url->getLongUrl());
        } else {
            header('Location: /short' );
        }

    }


    private function validateURL(string $longURL)
    {
        if (filter_var($longURL, FILTER_VALIDATE_URL) === false) {
            $_SESSION["errors"] = "Website not valid";
        }
    }

}
