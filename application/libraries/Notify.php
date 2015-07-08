<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notify{

    const KEYWORD = 'notify';
    private $items = [];

    function __construct(){}

    function add($message = false, $type = false){
        return $this->core($message, $type);
    }

    function addFlash($message = false, $type = false){
        return $this->core($message, $type, false);
    }

    function core($message = false, $type = false, $direct = true){
        if(!$type){
            $type = 'error';
        }
        $CI =& get_instance();
        if(!$message){
            return $this->items;
        }
        $item = [
            'type' => $type,
            'message' => $message,
        ];
        if($direct){
            array_push($this->items, $item);
        }else{
            $this->items = [];
            if($CI->session->flashdata(self::KEYWORD)){
                $items = $CI->session->flashdata(self::KEYWORD);
            }
            $items[] = $item;
            $CI->session->set_flashdata(self::KEYWORD, $items);
        }
        return false;
    }

    function collect(){
        $CI =& get_instance();
        if(!is_subclass_of($CI, 'Web_Controller')){
            return;
        }
        $items = $this->core();
        if($CI->session->flashdata(self::KEYWORD)){
            $items = array_merge(
                $items
                , $CI->session->flashdata(self::KEYWORD)
            );
        }
        /* bug chrome prefetch */
        $items = array_map(
            "unserialize"
            , array_unique(
                array_map("serialize", $items)
            )
        );
        /* bug chrome prefetch */
        $count = 0;
        $timeout = 1000;
        foreach($items as &$v){
            $v['timeout'] = $count+=$timeout;
        }
        $CI->_var(self::KEYWORD, $items);
    }
}