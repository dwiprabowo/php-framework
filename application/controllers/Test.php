<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TambalBan{

    var $name, $nitrogen, $change, $type, $lat, $lng;

    function __construct($params, $to_load){
        $this->to_load = $to_load;
        $this->name = $params[0];
        $this->nitrogen = $params[1];
        $this->change = $params[2];
        $this->type = $params[3];
        $this->lat = $params[4];
        $this->lng = $params[5];
        $this->data = [
            'latitude' => $this->lat,
            'longitude' => $this->lng,
            'type' => $this->get_type(),
            'name' => $this->name,
            'review_status' => 1,
        ];
        $this->inserted = $this->insert();
    }

    function get_type(){
        switch ($this->type) {
            case 1:
                return "motor";
                break;
            case 2:
                return "mobil";
                break;
            default:
                # code...
                break;
        }
    }

    function insert(){
        $this->to_load->load->model('location_model');
        $status = false;
        if(!$this->to_load->location_model->get_by($this->data)){
            $status = $this->to_load->location_model->insert($this->data);
        }
        return $status;
    }
}

class Test extends CLI_Controller{

    public function data_tj(){
        $data = [
            ["Jl. Kaliurang (Samping Bank Mandiri)", false, false, 1, -7.773444, 110.375315],
            ["Jl. Kaliurang (Pertigaan jl.Sarjito)", false, false, 1, -7.772149, 110.375851],
            ["Jl. Kaliurang (Pertigaan jl. Sarjito)", false, false, 1, -7.771998, 110.376045],
            ["Jl. Sarjito (Selatan Apotik UGM)", false, false, 1, -7.776471, 110.372061],
            ["Jl. Sarjito (Selatan Apotik UGM)", false, false, 1, -7.776704, 110.372021],
            ["Jl. Sarjito (Barat Sungai)", false, true, 1, -7.77832, 110.369905],
            ["Jl. Adisucipto", false, true, 1, -7.783383, 110.405104],
            ["Jl. Adisucipto", false, false, 1, -7.783415, 110.4094],
            ["Jl. Adisucipto (Sitepat)", true, true, 1, -7.783133, 110.398849],
            ["Jl. Adisucipto (Depan Social Agency)", false, false, 1, -7.783314, 110.398323],
            ["Jl. Adisucipto (Depan Social Agency)", false, false, 1, -7.783308, 110.398167],
            ["Jl. Adisucipto (Timur Jembatan Affandi)", false, false, 1, -7.783083, 110.396829],
            ["Jl. Adisucipto (Jembatan Affandi)", false, false, 1, -7.783287, 110.39658],
            ["Jl. Adisucipto (Timur Pertigaan UIN)", false, false, 1, -7.783096, 110.395802],
            ["Jl. Adisucipto (Depan Karya Rini)", false, false, 1, -7.78325, 110.392352],
            ["Jl. Adisucipto (Barat Karya Rini)", false, false, 1, -7.783218, 110.392009],
            ["Jl. Adisucipto (Samping De Brito)", false, false, 1, -7.783048, 110.392256],
            ["Jl. Adisucipto (Samping De Brito)", false, false, 1, -7.783005, 110.392229],
            ["Jl. Adisucipto", false, true, 1, -7.783189, 110.389464],
            ["Jl. Urip Sumoharjo", false, false, 1, -7.783101, 110.38416],
            ["Jl. Jend. Sudirman (Trafic Light)", false, false, 1, -7.783053, 110.372171],
            ["Jl. Jend. Sudirman (Timur Tugu)", false, false, 1, -7.782992, 110.367993],
            ["Jl. Jend. Sudirman (Timur Tugu)", false, false, 1, -7.782814, 110.367309],
            ["Jl. Magelang (Depan Bank BRI)", false, false, 1, -7.778849, 110.360815],
            ["Jl. Magelang (Pertigaan jl. Pakuningratan)", false, false, 1, -7.780826, 110.360769],
            ["Jl. Magelang (Pertigaan jl. Pakuningratan)", false, false, 1, -7.780773, 110.360759],
            ["Jl. Magelang (Pertigaan Hasil Karya Motor)", false, false, 1, -7.774565, 110.361142],
            ["Jl. Magelang (Depan Bank BCA)", false, false, 1, -7.771551, 110.361314],
            ["Jl. R. Wolter", false, false, 1, -7.779072, 110.362285],
            ["Jl. Kyai Mojo (Samping pasar)", false, false, 1, -7.782881, 110.358792],
            ["Jl. Kyai Mojo (Samping pasar)", false, false, 1, -7.782883, 110.358237],
            ["Jl. Kyai Mojo", false, false, 1, -7.781241, 110.350692],
            ["Jl. Colombo (Depan Gor UNY)", false, false, 1, -7.777305, 110.384453],
            ["Jl. Colombo (Depan Gor UNY)", false, false, 1, -7.777255, 110.384322],
            ["Jl. Colombo (Timur Trafic Light)", false, false, 1, -7.776627, 110.380197],
            ["Jl. Colombo", false, false, 1, -7.776936, 110.38202],
            ["Jl. Colombo (Utara Pantirapih)", false, false, 1, -7.776117, 110.378201],
            ["Jl. C. Simanjuntak (Depan pasar)", false, false, 1, -7.781576, 110.372477],
            ["Jl. C. Simanjuntak", false, false, 1, -7.781677, 110.372466],
            ["Jl. Suroto", false, false, 1, -7.784781, 110.374886],
            ["Jl. Abubakar Ali", false, false, 1, -7.789394, 110.3698],
            ["Jl. Mataram (Gardu PLN)", false, false, 1, -7.790425, 110.36788],
            ["Jl. Mataram (Kios sepatu)", false, false, 1, -7.79084, 110.367547],
            ["Jl. Mataram", false, false, 1, -7.794082, 110.367794],
            ["Jl. Mataram", false, false, 1, -7.795272, 110.368888],
            ["Jl. Mataram (Trafic light)", false, false, 1, -7.796856, 110.369393],
            ["Jl. Mataram", false, false, 1, -7.798695, 110.369167],
            ["Jl. Mataram (Trafic light)", false, false, 1, -7.797047, 110.369436],
            ["Jl. Mataram", false, false, 1, -7.798249, 110.369511],
            ["Jl. Mataram", false, true, 1, -7.79979, 110.3692],
            ["Jl. Suryopranoto", false, true, 1, -7.797175, 110.376045],
            ["Jl. Suryopranoto (Sekolah penyuluh pertanian)", false, false, 1, -7.797483, 110.378866],
            ["Jl. Suryopranoto (Barat sungai)", false, false, 1, -7.797356, 110.380315],
            ["Jl. Cendana", false, true, 1, -7.792038, 110.386073],
            ["Jl. Cendana", false, false, 1, -7.793859, 110.385572],
            ["Jl. Sambiloto", false, false, 1, -7.801884, 110.369167],
            ["Jl. Sambiloto", false, true, 1, -7.803606, 110.369114],
            ["Jl. Hos. Cokroaminoto", false, false, 1, -7.783665, 110.352645],
            ["Jl. Hos. Cokroaminoto", false, false, 1, -7.796144, 110.352538],
            ["Jl. Hos. Cokroaminoto", false, false, 1, -7.796739, 110.35243],
            ["Jl. Ahmad Dahlan (Samping Jembatan)", false, false, 1, -7.801172, 110.354844],
            ["Jl. Ahmad Dahlan (Terminal lama)", false, false, 1, -7.801214, 110.356346],
            ["Jl. Ahmad Dahlan", false, false, 1, -7.801257, 110.358031],
            ["Jl. Ahmad Dahlan (Depan RS. PKU)", false, false, 1, -7.801384, 110.362816],
            ["Jl. Sultan Agung (Timur Jembatan Sayidan)", false, false, 1, -7.801469, 110.37171],
            ["Jl. Sultan Agung (Trafic Light Bintaran Kidul)", false, false, 1, -7.801501, 110.372268],
            ["Jl. Sultan Agung (Masjid)", false, false, 1, -7.801714, 110.373985],
            ["Jl. Sultan Agung (Samping Musium Biologi)", false, false, 1, -7.801724, 110.37436],
            ["Jl. Sultan Agung", false, false, 1, -7.801767, 110.37569],
            ["Jl. Suryopranoto", false, false, 1, -7.801395, 110.377965],
            ["Jl. Suryopranoto", false, false, 1, -7.79962, 110.378169],
            ["Jl. Suryopranoto", false, false, 1, -7.798057, 110.378094],
            ["Jl. Ronodigdayan", false, false, 1, -7.796941, 110.377622],
            ["Jl. Ronodigdayan", false, false, 1, -7.789362, 110.378029],
            ["Jl. Ronodigdayan (Pertigaan Kridosono)", false, false, 1, -7.787863, 110.37833],
            ["Jl. Ronodigdayan (Pertigaan Kridosono)", false, false, 1, -7.787986, 110.378458],
            ["Jl. Ronodigdayan (Pertigaan Kridosono)", false, false, 1, -7.788108, 110.378469],
            ["Jl. Ronodigdayan", false, false, 1, -7.788374, 110.37819],
            ["Jl. Kusbini (DKD Pramuka)", false, false, 1, -7.78629, 110.382063],
            ["Jl. Kusbini", false, false, 1, -7.786088, 110.383898],
            ["Jl. Munggur", false, false, 1, -7.783463, 110.387868],
            ["Jl. Timoho", false, true, 1, -7.786854, 110.394831],
            ["Jl. Timoho (Samping rel kereta)", false, false, 1, -7.788044, 110.394359],
            ["Jl. Timoho (Samping rel kereta)", false, false, 1, -7.788544, 110.393683],
            ["Jl. Timoho (Depan Happyland)", false, false, 1, -7.793168, 110.393093],
            ["Jl. Timoho", false, true, 1, -7.796059, 110.392792],
            ["Jl. Kusumanegara (Trafic light)", false, false, 1, -7.801926, 110.39144],
            ["Jl. Kusumanegara", false, true, 1, -7.802203, 110.39084],
            ["Jl. Kusumanegara", false, false, 1, -7.80182, 110.388694],
            ["Jl. Kusumanegara (Sitepat)", true, true, 1, -7.80199, 110.384802],
            ["Jl. Kusumanegara", false, true, 1, -7.802118, 110.388179],
            ["Jl. Kusumanegara", false, false, 1, -7.801783, 110.381463],
            ["Jl. Kusumanegara", false, false, 1, -7.80181, 110.379907],
            ["Jl. Gejayan (Pertigaan toko Bata)", false, false, 1, -7.779168, 110.388544],
            ["Jl. Gejayan (Pelanet ban)", true, true, 1, -7.78203, 110.387766],
            ["Jl. Gejayan", false, false, 1, -7.781958, 110.38794],
            ["Jl. Komisaris Bambang S.", false, false, 1, -7.790319, 110.381345],
            ["Jl. Komisaris Bambang S.(Depan SPBU)", false, false, 1, -7.790032, 110.380175],
            ["Jl. Suryowijayan", false, false, 1, -7.804525, 110.356067],
            ["Jl. Suryowijayan", false, false, 1, -7.80789, 110.355917],
            ["Jl. Suryowijayan", false, false, 1, -7.811913, 110.355778],
            ["Jl. MT. Haryono", false, false, 1, -7.813212, 110.356263],
            ["Jl. MT. Haryono", false, false, 1, -7.813183, 110.355896],
            ["Jl. MT. Haryono", false, false, 1, -7.813279, 110.357977],
            ["Jl. MT. Haryono", false, false, 1, -7.813316, 110.357988],
            ["Jl. Brigjen. Katamso (Barat Purawisata)", false, false, 1, -7.809091, 110.368915],
            ["Jl. Brigjen. Katamso (Barat Purawisata)", false, false, 1, -7.809213, 110.36891],
            ["Jl. Brigjen. Katamso (Barat Purawisata)", false, false, 1, -7.808081, 110.36899],
            ["Jl. Brigjen. Katamso (Trafic Light)", false, false, 1, -7.804047, 110.369468],
            ["Jl. dr. Wahidin", false, false, 1, -7.783457, 110.379193],
            ["Jl. Prof. Yohanes", false, false, 1, -7.78114, 110.379226],
            ["Jl. Letjen. Suprapto", false, false, 1, -7.792572, 110.357022],
            ["Jl. Letjen. Suprapto", false, false, 1, -7.790574, 110.357559],
            ["Jl. Letjen. Suprapto", false, false, 1, -7.787045, 110.359941],
            ["Jl. P. Kemerdekaan (Univ. Cokroaminoto)", false, false, 1, -7.818338, 110.39114],
            ["Jl. P. Kemerdekaan (Barat SPBU)", false, false, 1, -7.81804, 110.389788],
            ["Jl. P. Kemerdekaan", false, false, 1, -7.817637, 110.387471],
            ["Jl. P. Kemerdekaan", false, false, 1, -7.817233, 110.384982],
            ["Jl. P. Kemerdekaan", false, false, 1, -7.816754, 110.381795],
            ["Jl. P. Kemerdekaan", false, false, 1, -7.816595, 110.380712],
            ["Jl. P. Kemerdekaan", false, false, 1, -7.816106, 110.377214],
            ["Jl. Ring Road", false, false, 1, -7.831433, 110.358138],
            ["Jl. Ring Road", false, false, 1, -7.833856, 110.361603],
            ["Jl. Ring Road", false, false, 1, -7.834303, 110.362741],
            ["Jl. Ring Road (Trafic Light Jl. Parangtritis)", false, false, 1, -7.835456, 110.365777],
            ["Jl. Ring Road (Trafic Light Jl. Parangtritis)", false, false, 1, -7.835392, 110.365686],
            ["Jl. Parangtritis (Depan Ruko)", false, false, 1, -7.830763, 110.367038],
            ["Jl. Parangtritis", false, false, 1, -7.826762, 110.367386],
            ["Jl. Kolonel Sugiyono", false, false, 1, -7.814607, 110.368931],
            ["Jl. Kolonel Sugiyono (Jembatan)", false, false, 1, -7.815436, 110.3748],
            ["Jl. Tamansiswa", false, false, 1, -7.813693, 110.376479],
            ["Jl. Tamansiswa (Trafic Light)", false, false, 1, -7.815094, 110.3763],
            ["Jl. Tamansiswa", false, false, 1, -7.805817, 110.378029],
            ["Jl. AM. Sangaji (Trafic Light)", false, false, 1, -7.762452, 110.369338],
            ["Jl. AM. Sangaji", false, true, 1, -7.763717, 110.369102],
            ["Jl. AM. Sangaji", false, true, 1, -7.764849, 110.368952],
            ["Jl. AM. Sangaji", false, false, 1, -7.765593, 110.369102],
            ["Jl. AM. Sangaji", false, false, 1, -7.765965, 110.369129],
            ["Jl. AM. Sangaji", false, false, 1, -7.776043, 110.367917],
            ["Jl. AM. Sangaji (Jetis)", false, false, 1, -7.778536, 110.367611],
            ["Jl. AM. Sangaji", false, false, 1, -7.779832, 110.3673],
            ["Jl. AM. Sangaji", false, false, 1, -7.781942, 110.367187],
            ["Jl. Colombo (Bundaran UGM)", false, false, 1, -7.776045, 110.376374],
            ["Jl. Cik Ditiro (Depan SMP 1 Jogja)", false, false, 1, -7.776484, 110.375856],
            ["Jl. Colombo (SPBU)", true, false, 1, -7.779665, 110.375272],
            ["Jl. Cik Ditiro (Samping RS. Mata YAP)", false, false, 1, -7.781222, 110.374977],
            ["Jl. Adisucipto (SPBU)", true, false, 1, -7.783181, 110.408102],
            ["Jl. Tamansiswa", false, false, 1, -7.807454, 110.377266],
            ["Jl. Adisucipto (Janti)", false, true, 2, -7.783393, 110.40983],
            ["Jl. Adisucipto (Janti)", false, true, 2, -7.783412, 110.409722],
            ["Jl. Jend. Sudirman (Timur jembatan)", false, true, 2, -7.783202, 110.371308],
            ["Jl. Jend. Sudirman (Timur jembatan)", false, true, 2, -7.783271, 110.371302],
            ["Jl. Jend. Sudirman (Timur jembatan)", false, true, 2, -7.783364, 110.371286],
            ["Jl. Hos. Cokroaminoto", false, true, 2, -7.783808, 110.352543],
            ["Jl. Hos. Cokroaminoto", false, true, 2, -7.787768, 110.353863],
            ["Jl. Hos. Cokroaminoto", false, true, 2, -7.797207, 110.352366],
            ["Jl. Kusumanegara", false, true, 2, -7.801565, 110.382879],
            ["Jl. Kusumanegara", false, true, 2, -7.801985, 110.382611],
            ["Jl. Magelang", false, true, 2, -7.781406, 110.360729],
            ["Jl. Magelang", false, true, 2, -7.769425, 110.361335],
            ["Jl. Colombo", false, true, 2, -7.776734, 110.380746],
            ["Jl. Parangtritis", false, true, 2, -7.833793, 110.366356],
            ["Jl. Mayjen Sutoyo", true, true, 2, -7.814288, 110.363803],
            ["Jl. Gedong Kuning (Barat JEC)", true, true, 2, -7.798512, 110.402223],
            ["Jl. AM. Sangaji", false, true, 2, -7.765593, 110.369102],
            ["Jl. Kyai Mojo (Timur Jembatan)", true, true, 2, -7.782867, 110.357328],
            ["Jl. Adisucipto (SPBU)", true, false, 2, -7.783181, 110.408102],
            ["Jl. Colombo (SPBU)", true, false, 2, -7.779665, 110.375272],
            ["Jl. Pasar Kembang", true, true, 2, -7.789543, 110.359205],
        ];
        foreach ($data as $index => $value) {
            $data[$index] = new TambalBan($value, $this);
        }
        $type = new stdclass;
        $type->data = [];
        $add_count = 0;
        foreach ($data as $index => $tambalban) {
            if(!in_array($tambalban->type, $type->data)){
                $type->data[] = $tambalban->type;
            }
            if($tambalban->inserted){
                $add_count++;
            }
        }
        echo "<pre>";
        // var_dump($type);
        var_dump($add_count." locations added!");
        // var_dump($data);
        echo "</pre>";
    }

    public function index(){
        return;
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
            [
                'latitude' => -7.4834501,
                'longitude' => 110.2236351,
            ],
            [
                'latitude' => -7.4839501,
                'longitude' => 110.2231351,
            ],
        ];
        $added_count = 0;
        foreach ($data as $index => $latlng) {
            if(!$this->location_model->get_by($latlng)){
                $this->location_model->insert($latlng);
                $added_count++;
            }
        }
        echo "$added_count locations added!";
    }
}