<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Map_model extends CI_Model
{
    public $table = 'tbl_gps';
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }
}