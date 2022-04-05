<?php

namespace App\Repositories\URL;

use App\Database;
use App\Models\URL;
use App\Services\URL\IndexURLRequest;
use App\Services\URL\ShortenURLRequest;
use Doctrine\DBAL\Exception;

class PDO_URLRepository implements URLRepository
{
    public function shorten(ShortenURLRequest $request): void
    {
        try {
            $check = Database::connection()->fetchAssociative('SELECT short_url FROM URL WHERE short_url = ?', [$request->getShortUrl()]);
        } catch (Exception $exception) {
            echo "Database Exception: " . $exception->getMessage();
            die;
        }


        if (empty($check)) {
            try {
                Database::connection()->insert('URL', [
                    'long_url' => $request->getLongUrl(),
                    'short_url' => $request->getShortUrl()
                ]);
            } catch (Exception $exception) {
                echo "Database Exception: " . $exception->getMessage();
                die;
            }
        }
    }

    public function fetchLast(int $number): array
    {
        try {
            $allData = Database::connection()->fetchAllAssociative('SELECT * FROM (SELECT * FROM URL ORDER BY id DESC LIMIT ' . $number . ') sub ORDER BY id DESC ');
        } catch (Exception $exception) {
            echo "Database Exception: " . $exception->getMessage();
            die;
        }

        $list = [];
        foreach ($allData as $data) {
            $list[] = new URL($data["id"], $data["long_url"], $data["short_url"]);
        }
        return $list;
    }

    public function index(IndexURLRequest $request): URL
    {
        try {
            $data = Database::connection()->fetchAssociative('SELECT * FROM URL WHERE short_url = ?', [$request->getPath() . $request->getShortURL()]);
        } catch (Exception $exception) {
            echo "Database Exception: " . $exception->getMessage();
            die;
        }


        return new URL($data['id'], $data['long_url'], $data['short_url']);
    }
}
