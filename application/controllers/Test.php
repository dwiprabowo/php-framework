<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CLI_Controller{

    public function index(){
        $this->load->model('location_model');
        $data = [
            [
                'latitude' => -7.4774774774774775,
                'longitude' => 110.23472306455649,
            ],
            [
                'latitude' => -7.5774774774774775,
                'longitude' => 110.33472306455649,
            ],
            [
                'latitude' => -7.3774774774774775,
                'longitude' => 110.73472306455649,
            ],
            [
                'latitude' => -7.4784774774774775,
                'longitude' => 110.23572306455649,
            ],
            [
                'latitude' => -7.4734774774774775,
                'longitude' => 110.23272306455649,
            ],
            [
                'latitude' => -7.4774501,
                'longitude' => 110.2285351,
            ],
            [
                'latitude' => -7.4784501,
                'longitude' => 110.2235351,
            ],
            [
                'latitude' => -7.4814501,
                'longitude' => 110.2255351,
            ],
            [
                'latitude' => -7.4804501,
                'longitude' => 110.2285351,
            ],
        ];
        foreach ($data as $index => $latlng) {
            if(!$this->location_model->get_by($latlng)){
                $this->location_model->insert($latlng);
            }
        }
    }
}