<?php

namespace Http;


class Response {

    protected $headers = array();
    protected $statusCode;
    protected $charset;
    protected $body;

    /**
     *
     */
    public function __construct(){

    }

    /**
     *
     */
    public function send(){
        foreach($this->headers as $key => $value){
            header($key . ": " . $value);
        }
        echo $this->body;
    }

    /**
     * @param $body
     */
    public function setBody($body){
        $this->body = $body;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $headers
     */
    public function addHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

} 