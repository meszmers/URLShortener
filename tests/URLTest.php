<?php

namespace Tests;

use App\Controllers\URLController;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase {

    public function testShortUrlValidator() {

        $builder = new ContainerBuilder();
        $container = $builder->build();

        $validate = new URLController($container);
        $one = $validate->validateURL('https://www.youtube.com/');
        $two = $validate->validateURL('www.youtube.com');


        self::assertFalse($one);
        self::assertTrue($two);
    }

    public function testGenerateHash() {
        $builder = new ContainerBuilder();
        $container = $builder->build();

        $validate = new URLController($container);

        $hash = $validate->generateHash();


        if($hash === null) {
            if($_SESSION['errors'] == 'Unexpected Error') {
                $check = true;
            } else {
                $check = false;
            }
        } else {
            $check = true;
        }

       self::assertTrue($check);
    }
}