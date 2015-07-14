<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function add_new_post(){
        $data = $this->input->post(null);
        $this->validate->setRules([
            'email ~ required|valid_email|autocorrect[email]',
            'password ~ required|min_length[8]',
        ]);
        if($this->validate->run()){
            $this->user_model->insert($data);
            notif(['success', 'message_new_user_created']);
            redirect('dashboard');
        }
    }

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
        $previous_pp = $this->login_model->getProfilePicture();
        $upload_pp = upload_image('profile_picture');
        $this->_var('profile_picture', $upload_pp);
        if(
            !$this->validate->run() 
            or 
            (!$upload_pp['status'])
        ){
            $upload_pp['previous_pp'] = $previous_pp;
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

    function _models(){
        return ['user', 'login'];
    }
}