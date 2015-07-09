<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function profile(){
        $this->_var(
            'user'
            , $this->user_model->get(
                $this->login_model->getData()
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
        if(!$this->validate->run()){
            notif('message_form_input_error', false);
        }else{
            $result = $this->user_model->update(
                $this->login_model->getData()
                , $this->input->post(null)
            );
            if(!$result){
                notif('message_failed_to_update_user_info', false);
            }else{
                notif(['success', 'message_succeed_update_user_info']);
                redirect('user/profile');
            }
        }
    }

    function _models(){
        return ['user', 'login'];
    }
}