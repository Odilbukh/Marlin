<?php
if( !session_id() ) @session_start();
require "../vendor/autoload.php";

use DI\ContainerBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    Engine::class => function() {
        return new Engine('../app/views');
    },
    PDO::class => function() {
        $driver = "mysql";
        $host = "localhost";
        $dbname = "marlin_4";
        $username = "root";
        $pwd = "root";

        return new PDO("$driver:host=$host;dbname=$dbname", $username, $pwd);
    },

    Auth::class => function($container) {
        return new Auth($container->get('PDO'));
    }
]);
$container = $containerBuilder->build();


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    //Views
    $r->addRoute('GET', '/', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', '/about', ['App\controllers\HomeController', 'about']);

    //User register
    $r->addRoute('GET', '/register', ['App\controllers\HomeController', 'register']);
    $r->addRoute('POST', '/register', ['App\controllers\HomeController', 'register']);

    //User login
    $r->addRoute('GET', '/login', ['App\controllers\HomeController', 'login']);
    $r->addRoute('POST', '/login', ['App\controllers\HomeController', 'login']);

    //User logout
    $r->addRoute('GET', '/logout', ['App\controllers\HomeController', 'logout']);

    //User management
    $r->addRoute('GET', '/admin', ['App\controllers\HomeController', 'admin']);

    //assignrole(simpleuser => admin)
    $r->addRoute('GET', '/assignrole', ['App\controllers\HomeController', 'assignrole']);

    //takeawayrole(admin => simple user)
    $r->addRoute('GET', '/takeawayrole', ['App\controllers\HomeController', 'takeawayrole']);
    $r->addRoute('GET', '/checkrolestatus', ['App\controllers\HomeController', 'takeawayrole']);

    //User profile
    $r->addRoute('GET', '/userprofile', ['App\controllers\HomeController', 'userprofile']);

    //Delete user
    $r->addRoute('GET', '/deleteuser', ['App\controllers\HomeController', 'deleteuser']);

    //User profile
    $r->addRoute('GET', '/profile', ['App\controllers\HomeController', 'profile']);
    $r->addRoute('POST', '/profile', ['App\controllers\HomeController', 'updateprofile']);


    //Change user info
    $r->addRoute('GET', '/changeuser', ['App\controllers\HomeController', 'changeuser']);
    $r->addRoute('POST', '/changeuser', ['App\controllers\HomeController', 'changeuser']);

    //Change user password
    $r->addRoute('GET', '/changepassword', ['App\controllers\HomeController', 'changepassword']);
    $r->addRoute('POST', '/changepasswordrequest', ['App\controllers\HomeController', 'changepasswordrequest']);

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
        // ... 404 Not Found
        echo "404 Page Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "Method not allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1],$routeInfo[2]);
        break;
}