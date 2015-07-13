<?php
defined('BASEPATH') or die('No direct access script allowed');

class Password extends App_Controller{

    private function _redirectIfLogin(){
        if($this->login_model->ready()){
            notif('message_invalid_link');
            redirect('user/profile');
        }
    }

    function change(){
        $user = $this->user_model->get($this->login_model->getId());
        if(!$user){
            notif('message_invalid_link');
            redirect('login');
        }
    }

    function change_post(){
        $this->validate->setRules([
            'new_password ~ required|min_length[8]',
        ]);
        if(!$this->validate->run()){
            return;
        }
        extract($this->input->post());
        $id = $this->login_model->getId();
        $user = $this->user_model->get_by([
            'id' => $id,
            'password' => md5($old_password),
        ]);
        if(!$user){
            notif('message_password_not_match', false);
            return;
        }
        $updated = $this->user_model->update($id, [
            'password' => $new_password
        ]);
        if($updated){
            notif(['success', 'message_success_change_password']);
            redirect('user/profile');
        }
        notif('message_something_wrong');
    }

    function request_link(){
        $this->_redirectIfLogin();
    }

    function request_link_post(){
        $this->_redirectIfLogin();
        extract($this->input->post());
        $this->validate->setRules(
            ['email ~ required|valid_email|autocorrect[email]']
        );
        if($this->validate->run()){
            $user = $this->user_model->get_by([
                'email' => $email
            ]);
            if(!$user){
                notif('message_couldnt_find_user_with_email', false);
            }else{
                $code = md5(uniqid().$user->id.$user->password);
                $update = $this->user_model->update($user->id, [
                    'password' => $code
                ]);
                send_mail(
                    $email
                    , "Reset Password Request"
                    , $this->load->view(
                        'template/email/basic'
                        , [
                            'link' => site_url('password/reset')."/$code"
                        ]
                        , true 
                    )
                );
                notif(['success', 'message_reset_link_sent_check_email'], false);
            }
        }
    }

    function reset($code=false){
        $this->_redirectIfLogin();
        $user = $this->user_model->get_by([
            'password' => md5($code)
        ]);
        if(!$user){
            notif('message_invalid_link');
            redirect('login');
        }
    }

    function reset_post($code=false){
        $this->_redirectIfLogin();
        $password = $this->input->post('password');
        $user = $this->user_model->get_by([
            'password' => md5($code)
        ]);
        $this->validate->setRules([
            'password ~ required|min_length[8]',
        ]);
        if($this->validate->run()){
            if($user){
                $updated = $this->user_model->update($user->id, [
                    'password' => $password
                ]);
                if($updated){
                    notif(['success', 'message_success_change_password']);
                    redirect('login');
                }
            }
        }
    }

    function check_email(){}

    function _models(){return ['user', 'login'];}
}