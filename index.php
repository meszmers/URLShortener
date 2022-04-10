<?php

require_once 'vendor/autoload.php';


use App\Redirect;
use App\Repositories\URL\URLRepository;
use App\View;
use DI\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function DI\create;

session_start();

/*
 * Load .env files into project
*/
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
$dotenv->load();

/*
 * Construct database based on .env input
*/
$database = trim('App\Repositories\URL\ ') . $_ENV['REPOSITORY'];

/*
 * Build a container
*/
$builder = new ContainerBuilder();
$builder->addDefinitions([
    URLRepository::class => create($database)
]);
$container = $builder->build();

/*
 * Creating a new file if file dose not exists.
*/
if($_ENV['REPOSITORY'] === 'JSON_URLRepository' && !file_exists(('public/' . $_ENV['FILE_NAME_JSON']))) {
    $fileName = ('public/' . $_ENV['FILE_NAME_JSON']);
    file_put_contents($fileName, json_encode([]));
}


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    //Website Routes
    $r->addRoute('GET', '/', [App\Controllers\WebsiteController::class, "index"]);
    $r->addRoute('GET', '/short', [App\Controllers\WebsiteController::class, "short"]);
    $r->addRoute('GET', '/long', [App\Controllers\WebsiteController::class, "long"]);

    //URL Routes
    $r->addRoute('POST', '/shorten', [App\Controllers\URLController::class, "shorten"]);
    $r->addRoute('POST', '/longURL', [App\Controllers\URLController::class, "longURL"]);
    $r->addRoute('GET', '/{short}', [App\Controllers\URLController::class, "redirect"]);

});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $controller = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        /*
         * Building given Controller and calling method
         */
        $response = (new $controller($container))->$method($vars);

        $twig = new Environment(new FilesystemLoader('app/Views'));


        if ($response instanceof View) {
            try {
                echo $twig->render($response->getPath(), $response->getVars());
            } catch (\Twig\Error\Error $e) {
                echo 'Twig Exception: ' . $e->getMessage();
                die;
            }
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getLocation());
        }

        break;
}

if (isset($_SESSION['errors']) && $httpMethod == "GET") {
    unset($_SESSION['errors']);
}

