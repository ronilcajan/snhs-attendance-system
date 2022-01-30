<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BiometricsModel extends CI_Model
{
    var $table = 'biometrics';
    var $column_order = array(null, 'firstname', 'lastname', 'middlename', 'date', 'am_in', 'am_out', 'pm_in', 'pm_out'); //set column field database for datatable orderable
    var $column_search = array('firstname', 'lastname', 'middlename', 'date', 'am_in', 'am_out', 'pm_in', 'pm_out'); //set column field database for datatable searchable 
    var $order = array('biometrics.date' => 'desc'); // default order 

    public function __contruct()
    {
        $this->load->database();
    }

    private function _get_datatables_query($date = '')
    {
        if ($date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
        }


        $this->db->select('*, biometrics.id as id');
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->join('personnels ', 'personnels.bio_id=biometrics.bio_id');

        if ($date) {
            $this->db->where('MONTH(biometrics.date)',  $month);
            $this->db->where('YEAR(biometrics.date)',  $year);
        } else {
            $this->db->where('MONTH(biometrics.date)',  date('m'));
            $this->db->where('YEAR(biometrics.date)',  date('Y'));
        }


        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($date = '')
    {
        $this->_get_datatables_query($date);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($date = '')
    {
        if ($date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
        }

        $this->_get_datatables_query($date);
        if ($date) {
            $this->db->where('MONTH(biometrics.date)',  $month);
            $this->db->where('YEAR(biometrics.date)',  $year);
        } else {
            $this->db->where('MONTH(biometrics.date)',  date('m'));
            $this->db->where('YEAR(biometrics.date)',  date('Y'));
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($date = '')
    {
        if ($date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
        }
        $this->db->from($this->table);

        if ($date) {
            $this->db->where('MONTH(biometrics.date)',  $month);
            $this->db->where('YEAR(biometrics.date)',  $year);
        } else {
            $this->db->where('MONTH(biometrics.date)',  date('m'));
            $this->db->where('YEAR(biometrics.date)',  date('Y'));
        }

        return $this->db->count_all_results();
    }

    public function bio($date)
    {
        if ($date) {
            $this->db->where('biometrics.date', $date);
        } else {
            $this->db->where('biometrics.date', date('Y-m-d'));
        }
        $this->db->join('personnels', 'personnels.bio_id=biometrics.bio_id');
        $this->db->order_by('personnels.lastname', 'ASC');
        $query = $this->db->get('biometrics');
        return $query->result();
    }

    public function save($data)
    {
        $this->db->insert('biometrics', $data);
        return $this->db->affected_rows();
    }
    public function update($data, $id)
    {
        $this->db->update('biometrics', $data, "id='$id'");
        return $this->db->affected_rows();
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('biometrics');
        return $this->db->affected_rows();
    }

    public function getBiometric($id)
    {
        $this->db->select('*, biometrics.id as id');
        $this->db->join('personnels', 'personnels.bio_id=biometrics.bio_id');
        $this->db->where('biometrics.id', $id);
        $query = $this->db->get('biometrics');
        return $query->row();
    }
    public function getBio($id, $date)
    {
        $this->db->where('biometrics.bio_id', $id);
        $this->db->where('biometrics.date', $date);
        $query = $this->db->get('biometrics');
        return $query->row();
    }
}
