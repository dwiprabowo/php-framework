<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    const ACTION_INACTIVATE = 0;
    const ACTION_ACTIVATE = 1;
    const ACTION_DELETE = 2;

    function lists(){
        $users = $this->user_model->get_all();
        $this->_var('users', $users);
    }

    function lists_post(){
        extract($this->input->post());
        $user = $this->user_model->get($id);
        if($user){
            $this->{'_action'.ucfirst($action)}($user);
        }else{
            log_message('error', 'User not found!');
        }
        $this->lists();
    }

    private function _theOnlyMaster($user){
        $count_master = $this->user_model->count_by([
            'role' => User_Model::ROLE_MASTER,
            'active' => 1,
        ]);
        if(
            (
                $user->role === User_Model::ROLE_MASTER
                and
                $user->active
            )
            and
            !($count_master > 1)
        ){
            return true;
        }
        return false;
    }

    private function _actionActivate($user){
        $updated = $this->user_model->update($user->id, [
            'active' => 1
        ]);
        if($updated){
            notif(['success', 'message_user_activated']);
            redirect('user/lists');
        }
    }

    private function _actionDeactivate($user){
        if($this->_theOnlyMaster($user)){
            notif('message_cannot_deactivate_user', false);
            return;
        }
        $updated = $this->user_model->update($user->id, [
            'active' => 0
        ]);
        if($updated){
            notif(['success', 'message_user_deactivated']);
            redirect('user/lists');
        }
    }

    private function _actionDelete($user){
        if($this->_theOnlyMaster($user)){
            notif('message_cannot_delete_user', false);
            return;
        }
        $deleted = $this->user_model->delete($user->id);
        if($deleted){
            notif(['success', 'message_user_deleted']);
            redirect('user/lists');
        }else{
            notif('message_something_wrong');
        }
        $this->lists();
    }

    function add_new_post(){
        $data = $this->input->post(null);
        $this->validate->setRules([
            'email ~ required|valid_email|autocorrect[email]',
            'password ~ required|min_length[8]',
        ]);
        if($this->validate->run()){
            $data['active'] = 1;
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