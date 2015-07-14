<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class Web_Controller extends WebMethod_Controller{

    private $twig_ext;
    private $twig_dir;
    private $http_methods = [
        'get', 'delete', 'post', 'put', 'options', 'patch', 'head'
    ];

    private $twig;
    private $var = [];
    private $request;
    private $idiom = "indonesian";
    private $current_uri = [];

    function __construct(){
        parent::__construct();
        $this->_init();
    }

    private function _init(){
        $this->twig_ext = ".html.twig";
        $this->twig_dir = APPPATH."views".DS;

        $this->load->library('form_validation', null, 'validate');
        $this->load->library('notify', null, 'notif');
        $this->load->library('autoCorrect', null, 'ac');
        $this->load->library('encryption');

        $this->load->helper('cookie');

        $this->_initTwig();
        $this->_initLang();
        $this->validate->set_error_delimiters('', '');

        $this->_tAllURI();
        
        if(defined('ENABLE_PROFILER') AND ENABLE_PROFILER){
            $this->output->enable_profiler(true);
        }
    }

    private function _tAllURI(){
        $current_uri = $_SERVER['REQUEST_URI'];
        $uri_string = $this->uri->uri_string();
        $languages = array_keys(config_item('available_languages'));
        $current_lang = config_item('language');

        $this->current_uri = [];

        $route = [];
        $route_path = APPPATH.'language/'.$current_lang.DS.'routes'.EXT;
        try{
            if(!@include($route_path)){
                throw new Exception("File not found: ".$route_path);
            }else{
                require $route_path;
            }
        }catch(Exception $e){
            log_message(
                'debug'
                , $e->getMessage().' ~ No problem! default routes should be used ...'
            );
        }
        $this->current_uri[$current_lang] = $uri_string;
        $real_uri = @$route[$uri_string];

        unset($languages[$current_lang]);

        foreach ($languages as $lang) {
            $route = [];
            $route_path = APPPATH.'language/'.$lang.DS.'routes'.EXT;
            try{
                if(!@include($route_path)){
                    throw new Exception("File not found: ".$route_path);
                }else{
                    require $route_path;
                }
            }catch(Exception $e){
                log_message(
                    'debug'
                    , $e->getMessage().' ~ No problem! default routes should be used ...'
                );
            }
            $found_uri = array_search($real_uri, $route);
            $this->current_uri[$lang] = $found_uri;
        }
    }

    function _getCurrentURI(){
        return $this->current_uri;
    }

    private function _initLang(){
        $lang = config_item('language');
        if($lang){
            $this->idiom = $lang;
        }
        $this->lang->load(['common', 'message'], $this->idiom);
    }

    private function _initTwig(){
        $twigLoader = new Twig_Loader_Filesystem($this->twig_dir);
        $this->twig = new Twig_Environment($twigLoader);
        $this->_generateTwigFilter();
    }

    private function _generateTwigFilter(){
        foreach ($this->_twigFilter() as $k => $v) {
            if(is_array($v)){
                $filter = new Twig_SimpleFunction($v[0], $v[1]);
            }else{
                $filter = new Twig_SimpleFunction($v, $v);
            }
            $this->twig->addFunction($filter);
        }
    }

    private function _twigFilter(){
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
            ['config', 'config_item'],
            'active_if_lang',
            'base_domain',
            'd',
            'is_lang',
            't',
            'url',
            'current_uri',
        ];
    }

    function _render(){
        $view = $this->_viewPath().$this->twig_ext;
        if(file_exists($this->twig_dir.$view)){
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

    private function _viewPath(){
        return $this->router->fetch_class()
            .DS
            .$this->router->fetch_method();
    }
}
