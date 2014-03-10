<?php
namespace View;

/**
 * Class View
 * @package Burrito\Framework
 */
class View {

    private $parent;

    /**
     *
     */
    public function __construct(){
    }

    // получить отренедеренный шаблон с параметрами $params
    /**
     * @param $template
     * @param array $params
     * @return string
     */
    function fetchPartial($template, $params = array()){
        extract($params);
        include '..\templates\\'.$template.'.php';
        return ob_get_clean();
    }

    // получить отренедеренный в переменную $content layout-а
    // шаблон с параметрами $params
    /**
     * @param $template
     * @param array $params
     * @return string
     */
    function fetch($template, $params = array()){
        ob_start();
        $content = $this->fetchPartial($template, $params);
        if ($this->parent){
            return $this->fetchPartial($this->parent, array('content' => $content));
        } else {
            return $content;
        }
    }

    // вывести отренедеренный в переменную $content layout-а
    // шаблон с параметрами $params
    /**
     * @param $template
     * @param array $params
     * @return string
     */
    function render($template, $params = array()){
        return $this->fetch($template, $params);
    }

    /**
     * @param $parent
     */
    function extend($parent){
        $this->parent = $parent;
    }

    /**
     * @param $pages
     */
    function paginationControl($pages){
        echo $pages->paginate();
    }

    /*
     *
     */
    function webRoot(){
        return preg_replace("/index.php/", '', $_SERVER['SCRIPT_NAME']);
    }
}