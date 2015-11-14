<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Auth_Controller{

    function __construct(){
        parent::__construct();
        if(!role_higher('admin')){
            redirect('user/profile');
        }
    }

    function index(){}
    
    function data_moderation($user_id = false){
        if($user_id){
            $this->data_moderation_detail($user_id);
        }else{
            $this->data_moderation_index();
        }
    }

    function ignore_location_report($id){
        $deleted = $this->location_report_model->delete($id);
        if($deleted){
            notif(['success', 'message_data_deleted']);
            redirect('dashboard/data_moderation');
        }
    }

    function delete_location_report($id){
        $report = $this->location_report_model->get($id);
        $deleted_location = 
            $this->location_model->delete($report->location_id);
        if($deleted_location){
            notif(['success', 'message_data_deleted']);
            redirect('dashboard/data_moderation');
        }
    }

    private function data_moderation_index(){
        $this->_var(
            'users',
            $this->google_user_model->get_data()
        );
        $this->_var(
            'location_reports',
            $this->location_report_model
                ->with(['google_user', 'location'])
                ->get_all()
        );
    }

    function action_data_moderation($action, $id){
        $this->{'action_data_moderation_'.$action}($id);
        notif('message_error_processing_data');
        redirect('dashboard/data_moderation');
    }

    private function action_data_moderation_approve($id){
        $updated = $this->location_model->update(
            $id, ['review_status' => 1]
        );
        if($updated){
            $location = $this->location_model->get($id);
            notif(['success', 'message_data_approved']);
            redirect(
                'dashboard/data_moderation/'
                .(
                    @$location->google_user_id?:'unknown'
                )
            );
        }
    }

    private function action_data_moderation_delete($id){
        $location = $this->location_model->get($id);
        $deleted = $this->location_model->delete($id);
        if($deleted){
            notif(['success', 'message_data_deleted']);
            redirect(
                'dashboard/data_moderation/'
                .(
                    @$location->google_user_id?:'unknown'
                )
            );
        }
    }

    private function data_moderation_detail($id){
        $user = $this->google_user_model->get($id);
        if($user){
            $user->detail = json_decode($user->data);
        }
        $locations = [];
        $locations = $this->location_model->get_many_by(
            [
                'google_user_id' => $user?$id:null,
                'review_status' => 0
            ]
        );
        if(!$locations){
            notif(['warning', 'message_no_data_to_process']);
            redirect('dashboard/data_moderation');
        }
        foreach ($locations as $index => &$location) {
            $location->url = "https://www.google.co.id/maps?q=loc:".
            "$location->latitude,$location->longitude";
        }
        $this->_var('user', $user);
        $this->_var('locations', $locations);
        $this->_setView('dashboard/data_moderation/detail');
    }

    function web_api(){}

    function users(){
        $this->_var(
            'users_count', 
            [
                'total' => $this->user_model->count_by(),
                'active' => $this->user_model->count_by(['active' => 1]),
                'inactive' => $this->user_model->count_by(['active' => 0]),
            ]
        );
        $this->_var('master_count', 
            [
                'total' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_MASTER
                ]),
                'active' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_MASTER, 'active' => 1
                ]),
                'inactive' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_MASTER, 'active' => 0
                ]),
            ]
        );
        $this->_var('admin_count', 
            [
                'total' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_ADMIN
                ]),
                'active' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_ADMIN, 'active' => 1
                ]),
                'inactive' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_ADMIN, 'active' => 0
                ]),
            ]
        );
        $this->_var('user_count', 
            [
                'total' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_USER
                ]),
                'active' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_USER, 'active' => 1
                ]),
                'inactive' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_USER, 'active' => 0
                ]),
            ]
        );
    }

    function _models(){
        return ['login', 'user', 'location', 'google_user', 'location_report'];
    }
}