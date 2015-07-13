<?php
defined('BASEPATH') or die('No direct access script allowed');

class Password extends App_Controller{

    function request_link_post(){
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

    function reset_post($code=false){
        $password = $this->input->post('password');
        $user = $this->user_model->get_by([
            'password' => $code
        ]);
        $this->validate->setRules([
            'password ~ required|min_length[8]',
        ]);
        if($this->validate->run()){
            if($user){
                $updated = $this->user_model->update($user->id, [
                    'password' => md5($password)
                ]);
                if($updated){
                    notif(['success', 'message_success_change_password']);
                    redirect('login');
                }
            }
        }
    }

    function check_email(){}

    function _models(){return ['user'];}
}