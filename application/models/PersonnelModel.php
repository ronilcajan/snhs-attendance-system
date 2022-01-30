<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PersonnelModel extends CI_Model
{

    public function __contruct()
    {
        $this->load->database();
    }

    public function personnels($id = "")
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('personnels');
        return $query->result();
    }

    public function getpersonnel($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('personnels');
        return $query->row();
    }

    public function create_personnel($data)
    {
        $this->db->insert('personnels', $data);
        return $this->db->affected_rows();
    }


    public function update($data, $id)
    {
        $this->db->update('personnels', $data, "id='$id'");
        return $this->db->affected_rows();
    }

    public function checkPersonnel($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('personnels');
        return $query->num_rows();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('personnels');
        return $this->db->affected_rows();
    }
}
