<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

    const KEYWORD = 'login';

    function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }

    function getProfilePicture(){
        return $this->user_model->getProfilePicture(
            $this->login_model->getId()
        );
    }

    function remember(){
        $user_id = get_cookie(self::KEYWORD);
        if($user_id){
            $decrypted_id = $this->encryption->decrypt($user_id);
            $this->session->set_userdata(
                self::KEYWORD
                , $decrypted_id
            );
            redirect();
        }
    }

    function signIn($email, $password, $remember){
        $result = $this->user_model->get_by([
            'email' => $email,
            'password' => md5($password),
        ]) and $this->setData($result, $remember);
        if(!$result)return false;
        $this->notif->addFlash(
            t('message_successfully_login')
            , 'success'
        );
        redirect('dashboard');
    }

    function signOut(){
        $this->deleteData();
        $this->notif->addFlash(
            t('message_successfully_logout')
            , 'info'
        );
        redirect('login');
    }

    function ready(){
        $result = $this->session->userdata(self::KEYWORD);
        return $result;
    }

    function getId(){
        return $this->ready();
    }

    function setData($user, $remember){
        if($user->id and $remember){
            $this->encryption->initialize([
                'cipher' => 'aes-256',
                'mode' => 'ctr',
            ]);
            $encrypted_id = $this->encryption->encrypt($user->id);
            set_cookie(
                self::KEYWORD
                , $encrypted_id
                , strtotime("+30 days") - time()
                , config_item('cookie_domain')
            );
        }
        $this->session->set_userdata(
            self::KEYWORD
            , $user->id
        );
    }

    function deleteData(){
        delete_cookie(self::KEYWORD);
        $this->session->unset_userdata(self::KEYWORD);
    }

    function _models(){
        return ['user'];
    }
}