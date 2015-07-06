<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Web_Controller extends MY_Controller{

    const TWIG_EXT = ".html.twig";
    const TWIG_DIR = APPPATH."views".DS;
    const HTTP_METHODS = [
        'get', 'delete', 'post', 'put', 'options', 'patch', 'head'
    ];

    private $twig;
    private $var = [];
    private $request;
    private $idiom = "indonesian";

    function _request(){
        $this->request = new stdClass();
        $this->request->method = $this->_detect_method();
    }

    function _detect_method(){
        $method = strtolower($this->input->server('REQUEST_METHOD'));
        if(in_array($method, self::HTTP_METHODS)){
            return $method;
        }
        return 'get';
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

    function _init(){
        $this->load->library('form_validation', null, 'validate');
        $this->load->library('notify', null, 'notif');
        $this->load->library('autoCorrect', null, 'ac');

        $this->_request();
        $this->_initTwig();
        $this->_initLang();
        $this->validate->set_error_delimiters('', '');
        
        if(defined('ENABLE_PROFILER') AND ENABLE_PROFILER){
            $this->output->enable_profiler(true);
        }
    }

    function _initLang(){
        $lang = config_item('language');
        if($lang){
            $this->idiom = $lang;
        }
        $this->lang->load(['common', 'message'], $this->idiom);
        $oops = $this->lang->line('common_hello'); 
    }

    function _initTwig(){
        $twigLoader = new Twig_Loader_Filesystem(self::TWIG_DIR);
        $this->twig = new Twig_Environment($twigLoader);
        $this->_generateTwigFilter();
    }

    function _generateTwigFilter(){
        foreach ($this->_twigFilter() as $k => $v) {
            if(is_array($v)){
                $filter = new Twig_Function($v[0], $v[1]);
            }else{
                $filter = new Twig_Function($v, $v);
            }
            $this->twig->addFunction($filter);
        }
    }

    function _twigFilter(){
        return [
            'base_url',
            'site_url',
            'set_value',
            'form_error',
            'twbs',
            'twbs_input',
            'twbs_h_input',
            'twbs_textarea',
            'twbs_h_textarea',
            'lang',
            ['config_item', 'config'],
            'active_if_lang',
            'base_domain',
            'd',
        ];
    }

    function _render(){
        $view = $this->_viewPath().self::TWIG_EXT;
        if(file_exists(self::TWIG_DIR.$view)){
            $template = $this->twig->loadTemplate($view);
            echo $template->render($this->_var());
        }else{
            show_404();
        }
    }

    function _var($key = false, $value = false){
        if(!$key){
            return $this->var;
        }
        $this->var[$key] = $value;
    }

    function _viewPath(){
        return $this->router->fetch_class()
            .DS
            .$this->router->fetch_method();
    }
}