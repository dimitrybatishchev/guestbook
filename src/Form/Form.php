<?php

namespace Form;

use Http\Request;

class Form{

    private $fields = array();
    private $params = array();

    /*
     *
     */
    public function __construct($params){
        $this->params = $params;
    }

    /**
     * @param $name
     * @param string $type
     * @param bool $required
     * @param array $params
     * @param array $validators
     * @param array $sanitizers
     * @return $this
     */
    public function add($name, $type = 'text', $required = false, $params = array(), $validators = array(), $sanitizers = array()){
        $this->fields[$name] = new Field($name, $type, $required, $params, $validators, $sanitizers);
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(){
        $valid = true;
        foreach($this->fields as &$field){
            if ($field->required == false && $field->value == ''){
                return $valid;
            }
            if ($field->required == true && $field->value == ''){
                $valid = false;
                $field->error = 'Required field';
            }
            foreach($field->validators as $validator){
                if (!$validator->validate($field->value)){
                    $valid = false;
                    $field->error = $validator->getError();
                }
            }
        }
        return $valid;
    }

    /*
     * Присваиваем каждому полю значение из реквеста
     *
     * */
    /**
     * @param Request $request
     */
    public function handleRequest(Request $request){
        foreach($this->fields as &$field){
            $field->value = $request->get($field->name);
            if (isset($field->sanitizers)){
                foreach($field->sanitizers as $sanitize){
                    $field->value = $sanitize->sanitize($field->value);
                }
            }
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getValue($name){
        return $this->fields[$name]->value;
    }

    /**
     * @return string
     */
    public function render(){
        $html = '';
        foreach ($this->fields as $field){
            $html .= '<div class="large-12 columns">';
            $params = '';
            if ($field->error){
                $field->params['class'] = ' error';
            }
            foreach ($field->params as $attribute => $value){
                $params .= ' ' . $attribute . '="' . $value . '"';
            }
            switch ($field->type) {
                case 'textarea':
                    $html .= '<textarea name="' . $field->name . '" ' . $params . '>' . $field->value . '</textarea>';
                    break;
                case 'submit':
                    $html .= '<input type="submit" class="button" name="' . $field->name . '" ' . $params . '>';
                    break;
                case 'file':
                    $html .= '<input type="file" name="' . $field->name . '" ' . $params . '>';
                    break;
                case 'email':
                    $html .= '<input type="text" value="' . $field->value . '" name="' . $field->name . '" ' . $params . '>';
                    break;
                case 'text':
                    $html .= '<input type="text" value="' . $field->value . '" name="' . $field->name . '" ' . $params . '>';
                    break;
                default:
                    break;
            };
            if ($field->error){
                $html .= '<small class="error">' . $field->error . '</small>';
            }
            $html .= '</div>';
        }
        return $html;
    }

}