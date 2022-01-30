<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personnel extends CI_Controller
{

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $data['title'] = 'Personnel Management';

        $data['person'] = $this->personnelModel->personnels();

        $this->base->load('default', 'personnel/manage', $data);
    }

    public function personnel_attendance($id)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $date = '';
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }

        $data['person'] = $this->personnelModel->getpersonnel($id);

        $data['title'] = 'Personnel Attendance Management';

        $data['attendance'] = $this->attendanceModel->getmyAttendance($id, $date);
        $data['id'] = $id;

        $this->base->load('default', 'personnel/personnel_attendance', $data);
    }

    public function create()
    {
        $this->session->set_flashdata('success', 'danger');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('mname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Middle Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[personnels.email]');
        $this->form_validation->set_rules('position', 'Personnel Position', 'trim|required');
        $this->form_validation->set_rules('bio', 'Personnel Biometrics ID', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', validation_errors());
        } else {

            $data = array(
                'firstname' => $this->input->post('fname'),
                'lastname' => $this->input->post('lname'),
                'middlename' => $this->input->post('mname'),
                'position' => $this->input->post('position'),
                'email' => $this->input->post('email'),
                'fb' => $this->input->post('fb_url'),
                'bio_id' => $this->input->post('bio'),
            );

            $insert =  $this->personnelModel->create_personnel($data);

            if ($insert) {
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'Personnel has been created!');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong please try again');
            }
        }
        redirect('personnel', 'refresh');
    }

    public function update()
    {
        $this->session->set_flashdata('success', 'danger');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('mname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Middle Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('position', 'Personnel Position', 'trim|required');
        $this->form_validation->set_rules('bio', 'Personnel Biometrics ID', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', validation_errors());
        } else {
            $id = $this->input->post('id');
            $data = array(
                'firstname' => $this->input->post('fname'),
                'lastname' => $this->input->post('lname'),
                'middlename' => $this->input->post('mname'),
                'position' => $this->input->post('position'),
                'email' => $this->input->post('email'),
                'fb' => $this->input->post('fb_url'),
                'status' => $this->input->post('status'),
                'bio_id' => $this->input->post('bio'),
            );

            $insert =  $this->personnelModel->update($data, $id);

            if ($insert) {
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'Personnel has been updated!');
            } else {
                $this->session->set_flashdata('message', 'No changes has been made!');
            }
        }
        redirect('personnel', 'refresh');
    }

    public function importCSV()
    {
        $config = array(
            'upload_path' => "./assets/uploads/CSV/",
            'allowed_types' => "csv",
            'encrypt_name' => TRUE,
        );

        $this->load->library('upload', $config);
        $this->form_validation->set_rules('import_file', 'CSV File', 'required');
        $this->session->set_flashdata('success', 'danger');

        if (!$this->upload->do_upload('import_file')) {

            $this->session->set_flashdata('message',  $this->upload->display_errors());
        } else {
            $file = $this->upload->data();

            // Reading file
            $data = fopen("./assets/uploads/CSV/" . $file['file_name'], "r");
            $i = 0;

            $importRes = array();

            if ($data) {
                // Initialize $importData_arr Array
                while (($filedata = fgetcsv($data, 1000, ",")) !== FALSE) {



                    // Skip first row & check number of fields
                    if ($i > 0) {

                        $email = $filedata[4];
                        $checkEmail = $this->personnelModel->checkPersonnel($email);

                        if ($checkEmail == 1) {
                            $this->session->set_flashdata('message', 'Importing has been stopped. Duplicate email address!');
                            redirect($_SERVER['HTTP_REFERER'], 'refresh');
                        } else {
                            // Key names are the insert table field names - name, email, city, and status
                            $importRes[$i]['lname'] = $filedata[0];
                            $importRes[$i]['fname'] = $filedata[1];
                            $importRes[$i]['mname'] = $filedata[2];
                            $importRes[$i]['position'] = $filedata[3];
                            $importRes[$i]['email'] = $filedata[4];
                            $importRes[$i]['fb_url'] = $filedata[5];
                            $importRes[$i]['bio'] = $filedata[6];
                        }
                    }
                    $i++;
                }

                fclose($data);

                // Insert data
                $count = 0;
                foreach ($importRes as $data) {

                    $pers = array(
                        'firstname' => $data['fname'],
                        'lastname' => $data['lname'],
                        'middlename' => $data['mname'],
                        'position' => $data['position'],
                        'email' => $data['email'],
                        'fb' => $data['fb_url'],
                        'bio_id' => $data['bio'],
                    );

                    $this->personnelModel->create_personnel($pers);
                    $count++;
                }
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'File Imported Successfully!');
            } else {
                $this->session->set_flashdata('message', 'Unable to open the file! Please contact support');
            }
        }

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function getPersonnel()
    {
        $validator = array('data' => array());

        $id = $this->input->post('id');

        $validator['data'] = $this->personnelModel->getpersonnel($id);

        echo json_encode($validator);
    }

    public function delete($id)
    {

        $delete = $this->personnelModel->delete($id);
        $this->session->set_flashdata('success', 'danger');

        if ($delete) {
            $this->session->set_flashdata('message', 'Personnel has been deleted!');
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. This borrower cannot be deleted!');
        }
        redirect('personnel', 'refresh');
    }
}
