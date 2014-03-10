<?php
/**
 * Created by PhpStorm.
 * User: dimit_000
 * Date: 2/2/14
 * Time: 7:24 PM
 */

namespace Form\Validate;


class Validator {

    // private $errorMsg сохраняет сообщение об ошибке,
    // если поле заполнено не корректно
    var $errorMsg;

    // конструктор
    function Validator ()
    {
        $this->errorMsg=array();
        $this->validate();
    }

    // абстрактный метод, предназначенный для наследования
    function validate() {}

    // добаляет сообщение о ошибке в массив
    function setError ($msg)
    {
        $this->errorMsg[]=$msg;
    }

    // возвращает значение true, если массив $errorMSG
    // не содержит сообщений о ошибке (пустой),
    // в противном случае возвращает false
    function isValid (){
        if ( isset ($this->errorMsg) ){
            return false;
        } else {
            return true;
        }
    }

    // Возвращает последний елемент из
    // массива $errorMsg, и удаляет последний елемент.
    function getError ()
    {
        return array_pop($this->errorMsg);
    }
}