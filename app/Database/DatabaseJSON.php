<?php

namespace App\Database;

class DatabaseJSON {

    private string $filename;

    public function __construct()
    {
        $this->filename = 'public/' . $_ENV['FILE_NAME_JSON'];
    }

    public function connection(): ?array {

        $input = file_get_contents($this->filename);
        return json_decode($input, true);

    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

}
