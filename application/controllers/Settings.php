<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     **/

    public function backup()
    {

        $this->load->dbutil();

        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'loanapp.sql',
            'ignore'        => array('users', 'groups', 'users_groups', 'login_attempts'),
            'foreign_key_checks' => FALSE
        );

        $backup = $this->dbutil->backup($prefs);

        $db_name = 'evaluation-backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = 'pathtobkfolder/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function restore()
    {

        $config['upload_path'] = './assets/backup/';
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('backup_file')) {

            $this->session->set_flashdata('errors',  $this->upload->display_errors());
        } else {
            $file = $this->upload->data();

            $sql = file_get_contents('./assets/backup/' . $file['file_name']);
            $string_query = rtrim($sql, '\n;');
            $array_query = explode(';', $sql);

            foreach ($array_query as $query) {
                $this->db->query($query);
            }
            $this->session->set_flashdata('message', 'Database Restored!');
        }

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function save_settings()
    {
        $config['upload_path'] = 'assets/uploads/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        $this->session->set_flashdata('success', 'danger');
        $id = $this->input->post('id');

        if ($this->ion_auth->is_admin()) {

            $this->form_validation->set_rules('sys_name', 'System Name', 'required|trim');
            $this->form_validation->set_rules('sys_acronym', 'System Acronym', 'required|trim');

            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('message', validation_errors());
            } else {

                if (!$this->upload->do_upload('sys_logo')) {
                    $data = array(
                        'system_name' => $this->input->post('sys_name'),
                        'system_acronym' => $this->input->post('sys_acronym'),
                    );
                } else {
                    $file = $this->upload->data();
                    //Resize and Compress Image
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'assets/uploads/' . $file['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['quality'] = '60%';
                    $config['new_image'] = 'assets/uploads/' . $file['file_name'];

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $data = array(
                        'system_logo' => $file['file_name'],
                        'system_name' => $this->input->post('sys_name'),
                        'system_acronym' => $this->input->post('sys_acronym'),
                    );
                }
                $update = $this->dashboardModel->update($data);

                if ($update) {
                    $this->session->set_flashdata('success', 'success');
                    $this->session->set_flashdata('message', 'System has been updated!');
                } else {
                    $this->session->set_flashdata('message', 'No changes has been made!');
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Your not an admin!');
        }

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }
}
