<?php

namespace Framework;

use Auryn\Injector;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class API
{
    public static $request;
    public static $method;
    public $config;

    /**
     * Auryn Injector instance
     * @var Injector
     */
    private $injector;

    public function __construct($config, $injector)
    {
        $this->config = $config;
        $this->injector = $injector;

        $this->setEnv();
    }

    protected function setEnv()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $whoops = new Run;
        if ($this->config['env'] !== 'production') {
            $whoops->pushHandler(new PrettyPageHandler);
        } else {
            $whoops->pushHandler(function ($e) {
                echo 'An error occurred.';
            });
        }
        $whoops->register();

        // Set header content-type to JSON
        header('Content-Type: application/json');

        // Set CORS to allow our environment
//        header('Access-Control-Allow-Origin: *');
    }

    public function route()
    {
        $request = Request::createFromGlobals();
        $response = null;

        // Set vars
        self::$request = strtolower($request->getPathInfo());
        self::$method = $_SERVER['REQUEST_METHOD'];

        // Determine proper lib child with hard limit of 4 entries
        // (to prevent overflow exceptions)
        $args = explode('/', self::$request, 4);

        // Pass to router, get our Model
        try {
            $model = Router::identify($args, $this->config);
        } catch (\Exception $e) {
            $model['namespace'] = 'App\Error';
        }

        if (class_exists($model['namespace'])) {
            if ($controller = $this->injector->make($model['namespace'])) {
                $response = call_user_func_array(array($controller, self::$method), array());

            } else {
                $response = new JsonResponse(array('error' => 'Failed to create controller.'), 404);
            }
        } else {
            $response = new JsonResponse(array('error' => 'Endpoint does not exist.'), 404);
        }

        if ($response == null) {
            throw new \Exception($model['namespace'] . ' did not return a Response');
        }

        $response->prepare($request);
        $response->send();
    }
}
