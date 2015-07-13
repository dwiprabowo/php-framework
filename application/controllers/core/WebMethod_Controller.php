<?php
defined('BASEPATH') or exit('No direct script access allowed');


abstract class WebMethod_Controller extends MY_Controller{

    private $http_methods = [
        'get', 'delete', 'post', 'put', 'options', 'patch', 'head',
    ];

    function __construct(){
        parent::__construct();
        $this->_init();
    }

    private function _detect_method(){
        $method = strtolower($this->input->server('REQUEST_METHOD'));
        if(in_array($method, $this->http_methods)){
            return $method;
        }
        return 'get';
    }

    private function _request(){
        $this->request = new stdClass();
        $this->request->method = $this->_detect_method();
    }

    function _remap($object, $args){
        $requested_method = $object.'_'.$this->request->method;

        $call_method = false;
        if(method_exists($this, $requested_method)){
            $call_method = $requested_method;
        }elseif(method_exists($this, $object)){
            $call_method = $object;
        }

        if($call_method){
            try{
                call_user_func_array(
                    [$this, $call_method]
                    , $args
                );
            }catch(Exception $e){
                error_message($e->getMessage());
            }
        }
    }

    private function _init(){
        $this->_request();
    }
}