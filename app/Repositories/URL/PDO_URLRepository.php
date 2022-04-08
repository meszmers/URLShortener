<?php

namespace App\Repositories\URL;


use App\Database\DatabasePDO;
use App\Models\URL;
use App\Services\URL\FetchLastURLRequest;
use App\Services\URL\IndexURLRequest;
use App\Services\URL\ShortenURLRequest;
use Doctrine\DBAL\Exception;

class PDO_URLRepository implements URLRepository
{
    private string $path;

    public function __construct()
    {
        $this->path = 'http'.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/' ;
    }

    public function shorten(ShortenURLRequest $request): void
    {
        try {
            $check = DatabasePDO::connection()->fetchAssociative('SELECT hash FROM URL WHERE hash = ?', [$request->getHash()]);

            if (empty($check)) {
                DatabasePDO::connection()->insert('URL', [
                    'long_url' => $request->getLongUrl(),
                    'hash' => $request->getHash()
                ]);
            }

        } catch (Exception $exception) {
            echo "DatabasePDO Exception: " . $exception->getMessage();
        }
    }

    public function fetchLast(FetchLastURLRequest $request): array
    {
        try {
            $allData = DatabasePDO::connection()->fetchAllAssociative('SELECT * FROM (SELECT * FROM URL ORDER BY id DESC LIMIT ' .$request->getNumber(). ') sub ORDER BY id DESC ');
        } catch (Exception $exception) {
            echo "DatabasePDO Exception: " . $exception->getMessage();
            die;
        }

        $list = [];
        foreach ($allData as $data) {
            $list[] = new URL($data["id"], $data["long_url"], ($this->path .$data["hash"]));
        }
        return $list;
    }

    public function index(IndexURLRequest $request): ?URL
    {
        try {
            $data = DatabasePDO::connection()->fetchAssociative('SELECT * FROM URL WHERE hash = ?', [$request->getHash()]);
        } catch (Exception $exception) {
            echo "DatabasePDO Exception: " . $exception->getMessage();
            die;
        }

        if($data["id"] !== null && $data["long_url"] !== null && $data["hash"] !== null) {
            return new URL($data['id'], $data['long_url'], ($this->path . $data['hash']));
        } else {
            return null;
        }
    }
}
