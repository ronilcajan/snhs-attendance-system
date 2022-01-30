<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{

    public function __contruct()
    {
        $this->load->database();
    }

    public function personnel()
    {
        $this->db->where('status', 1);
        $query = $this->db->get('personnels');
        return $query->num_rows();
    }

    public function update($data)
    {
        $this->db->update('systems', $data, "id=1");
        return $this->db->affected_rows();
    }
}
