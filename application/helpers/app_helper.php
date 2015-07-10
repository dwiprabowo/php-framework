<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('check_other_projects')){
    function check_other_projects(){
        $used_lang = config_item('language');
        $other_langs = config_item('available_languages');
        if(@$other_langs[$used_lang]){
            unset($other_langs[$used_lang]);
        }
        return array_map(
            function($v){ return $v."/"; }
            , array_column($other_langs, 'dir-code')
        );
    }
}

if(!function_exists('copy_to_other_projects')){
    function copy_to_other_projects($filepath, $filename, $relative_dir){
        log_message('error', 'filepath: '.$filepath);
        log_message('error', 'filename: '.$filename);
        $dirs = array_map(function($v){
            return PROJECT_BASEPATH.$v;
        }, check_other_projects());
        foreach ($dirs as $path) {
            $from = $filepath.$filename;
            $to = $path.$relative_dir.$filename;
            if(!copy($from, $to)){
                log_message('error', "Copy file to other project failed!");
            }else{
                log_message('debug', "File copied to other project ...");
            }
        }
    }
}

if(!function_exists('upload_image')){
    function upload_image($file_name = false, $is_ok = true){
        if(!$file_name){
            return [
                'status' => false,
                'message' => t('message_please_specify_field_name'),
            ];
        }
        if(
            !$_FILES[$file_name]['size'] 
            and 
            $is_ok
        ){
            return [
                'status' => true,
                'message' => t('message_upload_image_is_ok'),
            ];
        }
        $config = config_item('upload')['image'];
        if(!file_exists($config['upload_path'])){
            mkdir($config['upload_path'], 0777, true);
        }
        get_instance()->load->library('upload', $config);
        if(!get_instance()->upload->do_upload($file_name)){
            $result = [
                'status' => false,
                'message' => get_instance()->upload->display_errors('', ''),
            ];
        }else{
            $result = [
                'status' => true,
                'data' => get_instance()->upload->data(),
            ];
            copy_to_other_projects(
                $result['data']['file_path']
                , $result['data']['file_name']
                , str_replace(FCPATH, '', $config['upload_path'])
            );
        }
        return $result;
    }
}