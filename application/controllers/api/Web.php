<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends REST_Controller{

    function get_locations_get($user_id = false){
        $result = [
            'status' => false,
            'message' => 'Unknown Error!',
        ];

        log_message('error', "user_id: ".$user_id);
        $this->load->model('location_model');
        $this->db->select(
            'latitude, longitude, name, open_time, close_time, type'
        );
        $locations = $this->location_model
            ->get_many_by([
                'review_status' => 1,
            ]);

        if($user_id){
            $this->db->select('latitude, longitude');
            $user_locations = $this->location_model
            ->get_many_by([
                'review_status' => 0,
                'google_user_id' => $user_id
            ]);
            foreach ($user_locations as $key => $value) {
                $value->is_pending = true;
            }
            log_message('error', "user_locations: ".ds($user_locations));
            log_message('error', "locations_count: ".count($locations));
            $locations = array_merge($locations, $user_locations);
            log_message('error', "locations_count after merge: ".count($locations));
        }


        log_message('error', $this->db->last_query());
        // $locations = [];
        if($locations){
            $result = [
                'status' => true,
                'data_count' => count($locations),
                'data' => $locations,
            ];
        }else{
            $result['message'] = "Couldn't retrieve any location";
        }

        $this->response($result, 200);
    }

    function get_locations_with_user_get($user_id){
        $result = [
            'status' => false,
            'message' => 'Unknown Error!',
        ];

        $this->load->model('location_model');

        $locations = $this->location_model->get_with_user_locations($user_id);
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

        $google_user = json_decode(
            str_replace("#dan#", "&", $data['google_user_data'])
        );

        if(!$this->google_user_model->get($google_user->id)){
            $user_inserted = $this->google_user_model->insert([
                'id' => $google_user->id,
                'data' => $data['google_user_data'],
            ]);
        }elseif(
            $this->google_user_model->get($google_user->id)->data
            !=
            $data['google_user_data']
        ){
            $this->google_user_model->update(
                $google_user->id,
                ['data' => $data['google_user_data']]
            );
        }

        $latlng = [
            'google_user_id' => $google_user->id,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ];
        if($data['title']){
            $latlng['name'] = $data['title'];
        }
        if($data['type']){
            $latlng['type'] = $data['type'];
        }
        if($data['open_time'] and strtolower($data['open_time']) != "buka"){
            $latlng['open_time'] = $data['open_time'];
        }
        if($data['close_time'] and strtolower($data['close_time']) != "tutup"){
            $latlng['close_time'] = $data['close_time'];
        }

        log_message('error', "latlng data: ".ds($latlng));
        if($this->location_model->insert($latlng)){
            log_message('error', "latlng data inserted");
            $result = [
                'status' => true,
                'message' => 'Location added!',
            ];
        }else{
            log_message('error', "latlng data fail insert");
        }

        $this->response($result, 200);
    }
}