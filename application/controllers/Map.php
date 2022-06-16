<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Map extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Map_model');
    }

    public function index()
    {
        $data['map'] = $this->Map_model->get();
        $this->load->view('map/index', $data);
    }


    public function get_data()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->Map_model->getDataGps();

            // if ($data) {
            //     $output = array(
            //         'success' => true,
            //         'data' => $data
            //     );

            echo json_encode($data);
            // }
        } else {
            echo 'false';
        }
    }
}