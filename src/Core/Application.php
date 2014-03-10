<?php
namespace Core;

use Http\Request;
use Routing\Router;
use View\View;
use Core\ServiceContainer;
use Http\Response;

class Application {

    private $callbacks = array();

    public $request;
    public $response;
    private $router;

    public $service;

    /*
     *
     */
    public function __construct(){
        $this->callbacks['GET'] = array();
        $this->callbacks['POST'] = array();
        $this->callbacks['ALL'] = array();

        $this->service = new ServiceContainer();

        $this->request = new Request();
        $this->response = new Response();
    }


    /**
     *
     */
    public function run(){
        $this->router = new Router($this->callbacks);
        $callback = $this->router->match($this->request);
        $context = $callback['callback']();
        $view = new View();
        if (isset($callback['template'])){
            $this->response->addHeader('Content-Type', 'text/html');
            $html = $view->render($callback['template'], $context);
            $this->response->setBody($html);
        }
        $this->response->send();
    }

    /**
     * @param $route
     * @param $callback
     * @param null $template
     */
    public function get($route, $callback, $template = null){
        $this->callbacks['GET'][] = array(
            'route' => $route,
            'callback' => $callback,
            'template' => $template
        );
    }

    /**
     * @param $route
     * @param $callback
     * @param null $template
     */
    public function post($route, $callback, $template = null){
        $this->callbacks['POST'][] = array(
            'route' => $route,
            'callback' => $callback,
            'template' => $template
        );
    }

    /**
     * @param $route
     * @param $callback
     * @param null $template
     */
    public function match($route, $callback, $template = null){
        $this->callbacks['ALL'][] = array(
            'route' => $route,
            'callback' => $callback,
            'template' => $template
        );
    }

    /**
     * @param $url
     */
    public function redirect($url){
        $this->response->addHeader('Location', $_SERVER['SCRIPT_NAME'] . $url);
        $this->response->send();
        die;
    }

}