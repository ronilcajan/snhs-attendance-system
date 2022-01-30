<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Biometrics extends CI_Controller
{
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $data['title'] = 'Biometrics Attendance Management';

        $data['attendance'] = $this->attendanceModel->attendance();
        $data['person'] = $this->personnelModel->personnels();

        $this->base->load('default', 'bio/manage', $data);
    }

    public function get_bio()
    {
        $date = $_POST['date'];

        $list = $this->biometricsModel->get_datatables($date);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bio) {
            $no++;
            $row = array();
            $row[] = date('m/d/Y', strtotime($bio->date));
            $row[] = $bio->lastname . ', ' . $bio->firstname . ' ' . $bio->middlename;
            $row[] = empty($bio->am_in) ? null : date('h:i A', strtotime($bio->am_in));
            $row[] = empty($bio->am_out) ? null : date('h:i A', strtotime($bio->am_out));
            $row[] = empty($bio->pm_in) ? null : date('h:i A', strtotime($bio->pm_in));
            $row[] = empty($bio->pm_out) ? null : date('h:i A', strtotime($bio->pm_out));
            $row[] = '
                 <div class="form-button-action">
                    <a type="button" href="' . $bio->fb . '" data-toggle="tooltip" class="btn btn-link btn-primary mt-1 p-1" data-original-title="Facebook URL" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a type="button" href="#editBio" data-toggle="modal" class="btn btn-link btn-success mt-1 p-1" title="Edit Biometrics" data-id="' . $bio->id . '" onclick="editBio(this)">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a type="button" href="' . site_url("biometrics/delete/" . $bio->id) . '" data-toggle="tooltip" onclick="return confirm(&quot;Are you sure you want to delete this biometrics attendance?&quot);" class="btn btn-link btn-danger mt-1 p-1" data-original-title="Remove">
                        <i class="fa fa-times"></i>
                    </a>
                </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->biometricsModel->count_all($date),
            "recordsFiltered" => $this->biometricsModel->count_filtered($date),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create()
    {
        $this->session->set_flashdata('success', 'danger');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('bio_id', 'Personnel Biometrics ID', 'trim|required');
        $this->form_validation->set_rules('am_in', 'Morning In', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', validation_errors());
        } else {

            $data = array(
                'date' => $this->input->post('date'),
                'am_in' => $this->input->post('am_in'),
                'am_out' => $this->input->post('am_out'),
                'pm_in' => $this->input->post('pm_in'),
                'pm_out' => $this->input->post('pm_out'),
                'bio_id' => $this->input->post('bio_id'),
            );

            $insert =  $this->biometricsModel->save($data);

            if ($insert) {
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'Biometrics attendance has been created!');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong. Please try again!');
            }
        }
        redirect('biometrics', 'refresh');
    }

    public function generate_bioreport()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $date = '';
        if (isset($_GET['date'])) {
            $date = $_GET['date'];
        }
        $data['bio'] = $this->biometricsModel->bio($date);

        $data['title'] = 'Biometrics Report';

        $this->base->load('default', 'bio/generate_bio', $data);
    }

    public function update()
    {
        $this->session->set_flashdata('success', 'danger');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('bio_id', 'Personnel Biometrics ID', 'trim|required');
        $this->form_validation->set_rules('am_in', 'Morning In', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', validation_errors());
        } else {

            $id = $this->input->post('id');
            $data = array(
                'date' => $this->input->post('date'),
                'am_in' => $this->input->post('am_in'),
                'am_out' => $this->input->post('am_out'),
                'pm_in' => $this->input->post('pm_in'),
                'pm_out' => $this->input->post('pm_out'),
                'bio_id' => $this->input->post('bio_id'),
            );

            $update =  $this->biometricsModel->update($data, $id);

            if ($update) {
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'Biometrics attendance has been updated!');
            } else {
                $this->session->set_flashdata('message', 'No changes has been made!');
            }
        }
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function importCSV()
    {
        $config = array(
            'upload_path' => "./assets/uploads/CSV/",
            'allowed_types' => "csv",
            'encrypt_name' => TRUE,
        );

        $date =  $this->input->post('from');

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
                        if (!empty($date)) {
                            if ($date == date('Y-m-d', strtotime($filedata[8]))) {
                                $importRes[$i]['date'] = $filedata[8];
                                $importRes[$i]['id'] = $filedata[2];
                                $importRes[$i]['time'] = $filedata[8];
                            }
                        } else {
                            $importRes[$i]['date'] = $filedata[8];
                            $importRes[$i]['id'] = $filedata[2];
                            $importRes[$i]['time'] = $filedata[8];
                        }
                    }
                    $i++;
                }

                fclose($data);

                // Insert data
                $count = 0;
                foreach ($importRes as $data) {

                    $id = $data['id'];
                    $date = date('Y-m-d', strtotime($data['date']));
                    $time = date('H:i:s', strtotime($data['time']));
                    $checkAttend = $this->biometricsModel->getBio($id, $date);

                    if (!empty($checkAttend)) {

                        if ($checkAttend->am_in == '') {
                            $logs = array(
                                'am_in' =>  $time
                            );
                            $this->biometricsModel->update($logs, $checkAttend->id);
                        } elseif ($checkAttend->am_out == '') {
                            $logs = array(
                                'am_out' => $time
                            );
                            $this->biometricsModel->update($logs, $checkAttend->id);
                        } elseif ($checkAttend->pm_in == '') {
                            $logs = array(
                                'pm_in' => $time
                            );
                            $this->biometricsModel->update($logs, $checkAttend->id);
                        } else {
                            $logs = array(
                                'pm_out' => $time
                            );
                            $this->biometricsModel->update($logs, $checkAttend->id);
                        }
                    } else {
                        $logs = array(
                            'date' => $date,
                            'am_in' => $time,
                            'bio_id' =>  $id,
                        );

                        $this->biometricsModel->save($logs);
                    }
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

    public function getBio()
    {
        $validator = array('data' => array());

        $id = $this->input->post('id');

        $validator['data'] = $this->biometricsModel->getBiometric($id);

        echo json_encode($validator);
    }

    public function delete($id)
    {

        $delete = $this->biometricsModel->delete($id);
        $this->session->set_flashdata('success', 'danger');

        if ($delete) {
            $this->session->set_flashdata('message', 'Biometrics attendance has been deleted!');
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. This attendance cannot be deleted!');
        }
        redirect('biometrics', 'refresh');
    }
}
