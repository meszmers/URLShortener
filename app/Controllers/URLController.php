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

    public function shorten(): Redirect
    {
        $longURL = $_POST["long_url"];
        $this->validateURL($longURL);

        $hash = $this->generateHash();

        if (empty($_SESSION["errors"])) {
            (new ShortenURLService())->execute(new ShortenURLRequest($longURL, $hash));
        }

        return new Redirect('/short');
    }


    public function redirect($vars)
    {
        $url = (new IndexURLService())->execute(new IndexURLRequest($vars["short"]));

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

    private function generateHash(): ?string {
        try {
            $bytes = random_bytes(6);
            return bin2hex($bytes);
        } catch (Exception $exception) {
            $_SESSION['errors'] = 'Unexpected Error';
            return null;
        }

    }
}
