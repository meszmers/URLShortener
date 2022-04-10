<?php

namespace Tests;

use App\Models\URL;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase {
    public function test_URL_Model() {
        $model = new URL(11, 'test123456789.com/123456789', 'test123.com/123');

        self::assertSame(11, $model->getId());
        self::assertSame('test123456789.com/123456789', $model->getLongUrl());
        self::assertSame('test123.com/123', $model->getShortUrl());

    }
}

