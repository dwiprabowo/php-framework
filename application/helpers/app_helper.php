<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        }
        return $result;
    }
}