<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends REST_Controller{

    function get_locations_get(){
        $result = [
            'status' => false,
            'message' => 'Unknown Error!',
        ];

        $this->load->model('location_model');
        $this->db->select('latitude, longitude');
        $locations = $this->location_model
            ->get_all();
        // $locations = [];
        if($locations){
            $result = [
                'status' => true,
                'data' => $locations,
            ];
        }else{
            $result['message'] = "Couldn't retrieve any location";
        }

        $this->response($result, 200);
    }

    function add_user_locations_post(){
        $this->load->model('google_user_model');
        $this->load->model('location_model');

        $data = $this->input->post(null);
        $result = [
            'status' => false,
            'message' => 'add_user_locations error',
            'data' => $data,
        ];
        $google_user = json_decode($data['google_user_data']);

        if(!$this->google_user_model->get($google_user->id)){
            $user_inserted = $this->google_user_model->insert([
                'id' => $google_user->id,
                'data' => $data['google_user_data'],
            ]);
        }

        $latlng = [
            'google_user_id' => $google_user->id,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ];

        if($this->location_model->insert($latlng)){
            $result = [
                'status' => true,
                'message' => 'Location added!',
            ];
        }

        $this->response($result, 200);
    }
}