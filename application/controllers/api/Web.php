<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends REST_Controller{

    function locations_get(){
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

    function locations_post(){
        $data = $this->input->post(null);
        $result = [
            'error' => true,
            'message' => 'locations_post',
            'data' => $data,
        ];
        $this->response($result, 200);
    }

}