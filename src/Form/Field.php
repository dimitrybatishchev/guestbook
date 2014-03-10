<?php

namespace Form;

class Field{

    public $name;
    public $type;
    public $required;
    public $params;
    public $validators;
    public $sanitizers;

    public $error;
    public $value;

    /*
     *
     */
    public function __construct($name, $type, $required, $params, $validators, $sanitizers){
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->params = $params;
        $this->validators = $validators;
        $this->sanitizers = $sanitizers;
    }

}
