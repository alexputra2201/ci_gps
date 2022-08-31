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
        $this->load->view('layout/header');
        $this->load->view('map/index');
        $this->load->view('layout/footer');
    }


    public function get_data()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->db->get('tbl_gps')->result();
            echo json_encode($data);
        } else {
            echo 'false';
        }
    }

    public function proses_save()
    {
        $item = $this->input->post();

        foreach ($item as $row) {
            $data = array(
                'lat' => $row['lat'],
                'lng' => $row['lng'],
                'created_date' => $row['created_date']
            );

            $result = $this->db->insert('tbl_gps', $data);

            if ($result) {
                $output = array(
                    'success' => true,
                    'message' => 'Data has been saved successfully'
                );
            } else {
                $output = array(
                    'error' => true,
                    'message' => 'Data has not been saved successfully'
                );
            }
            echo json_encode($output);
        }
    }
}