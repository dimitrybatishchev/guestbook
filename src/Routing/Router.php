<?php
namespace Routing;

use Http\Request;

class Router {

    private $callbacks;

    /**
     * @param $callbacks
     */
    public function __construct(&$callbacks){
        $this->callbacks = $callbacks;
    }

    /**
     * @param Request $request
     * @return Closure
     */
    public function match(Request $request){
        $uri = $request->getPathInfo();
        foreach($this->callbacks[$request->getMethod()] as $callback){
            $pattern = $callback['route'];
            if(preg_match("~$pattern~", $uri)){
                return $callback;
            }
        }
        foreach($this->callbacks['ALL'] as $callback){
            $pattern = $callback['route'];
            if(preg_match("~$pattern~", $uri)){
                return $callback;
            }
        }

    }

}