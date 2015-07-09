<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function profile(){
        $this->_var(
            'user'
            , $this->user_model->get(
                $this->login_model->getId()
            )
        );
    }

    function profile_post(){
        $this->validate->setRules([
            'fullname ~ required|alpha_space|autocorrect[name]',
            'gender ~ required',
            'birth_date ~ required|valid_date',
            'birth_place ~ required',
            'email ~ required|valid_email|autocorrect[email]',
            'phone ~ required',
            'occupation ~ required',
            'address ~ required',
        ]);
        $upload_pp = $this->_doUpload();
        $this->_var('profile_picture', $upload_pp);
        if(!$this->validate->run() or !$upload_pp['status']){
            $this->_var(
                'user'
                , ['profile_picture' => $upload_pp['previous_pp']]
            );
            notif('message_form_input_error', false);
        }else{
            $update_data = $this->input->post(null);
            if($upload_pp['data']){
                $update_data['profile_picture'] = str_replace(
                    FCPATH
                    , ''
                    , $upload_pp['data']['full_path']
                );
            }
            $result = $this->user_model->update(
                $this->login_model->getId()
                , $update_data
            );
            if(!$result){
                notif('message_failed_to_update_user_info', false);
            }else{
                notif(['success', 'message_succeed_update_user_info']);
                redirect('user/profile');
            }
        }
    }

    function _doUpload(){
        $file_name = 'profile_picture';
        if(
            !$_FILES[$file_name]['size'] 
            and 
            $this->user_model->get(
                $this->login_model->getData()
            )->profile_picture
        ){
            return ['status' => true];
        }
        $config['upload_path']          = FCPATH.'assets/img/upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        if(!file_exists($config['upload_path'])){
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload($file_name)){
            $result = [
                'status' => false,
                'message' => $this->upload->display_errors('', ''),
                'previous_pp' => $this->login_model->getProfilePicture(),
            ];
        }else{
            $result = [
                'status' => true,
                'data' => $this->upload->data(),
            ];
        }
        return $result;
    }

    function _models(){
        return ['user', 'login'];
    }
}