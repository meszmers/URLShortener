<?php

namespace App\Repositories\URL;

use App\Database\DatabaseJSON;
use App\Models\URL;
use App\Services\URL\FetchLastURLRequest;
use App\Services\URL\IndexURLRequest;
use App\Services\URL\ShortenURLRequest;

class JSON_URLRepository implements URLRepository {

    private array $data;
    private string $path;

    public function __construct()
    {
        $this->data = (new DatabaseJSON())->connection();
        $this->path = 'http'.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/' ;
    }

    public function shorten(ShortenURLRequest $request): void
    {

        $tempArray = $this->data;

        if(empty($tempArray)) {
            $id = 1;
        } else {
            $id = array_search(end($tempArray), $tempArray) + 1;
        }

        $tempArray[$id] = ['long_url' => $request->getLongUrl(), 'hash' => $request->getHash()];
        $filename = (new DatabaseJSON())->getFilename();
        $tempArray = json_encode($tempArray);
        file_put_contents($filename, $tempArray);
    }

    public function fetchLast(FetchLastURLRequest $request): array
    {

        $tempArray = array_reverse($this->data);
        $data = [];

        $k = array_keys($tempArray);
        $v = array_values($tempArray);
        $rv = array_reverse($v);
        $tempArray = array_combine($k, $rv);

        if(!empty($tempArray)) {
            $c = 0;
            foreach ($tempArray as $i=> $URL) {
                $c +=1;
                $data[] = new URL($i, $URL['long_url'], $this->path . $URL['hash']);
                if($c == $request->getNumber()) {
                    break;
                }
            }
        }

        return $data;
    }

    public function index(IndexURLRequest $request): ?URL
    {
        $tempArray = $this->data;

        $url = null;
        foreach ($tempArray as $index=> $see) {
            if($see['hash'] == $request->getHash()) {
                $url = new URL($index, $see['long_url'], $see['hash']);
                break;
            }
        }

        return $url;
    }
}