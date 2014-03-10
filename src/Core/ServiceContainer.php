<?php
/**
 * Created by PhpStorm.
 * User: dimit_000
 * Date: 1/29/14
 * Time: 1:34 PM
 */

namespace Core;


class ServiceContainer extends \ArrayObject{

    /*
     * @param $key
     */
    public function get($key){
        if (is_callable($this[$key])){
            $this[$key] = call_user_func($this[$key]);
        }
        return $this[$key];
    }

} 