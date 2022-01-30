<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $data['title'] = 'Attendance Management';

        $data['attendance'] = $this->attendanceModel->attendance();
        $data['person'] = $this->personnelModel->personnels();

        $this->base->load('default', 'attendance/manage', $data);
    }

    public function get_attendance()
    {
        $date = $_POST['date'];

        $list = $this->attendanceModel->get_datatables($date);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $attend) {
            $no++;
            $row = array();
            $row[] = date('m/d/Y', strtotime($attend->date));
            $row[] = $attend->lastname . ', ' . $attend->firstname . ' ' . $attend->middlename;
            $row[] = empty($attend->morning_in) ? null : date('h:i A', strtotime($attend->morning_in));
            $row[] = empty($attend->morning_out) ? null : date('h:i A', strtotime($attend->morning_out));
            $row[] = empty($attend->afternoon_in) ? null : date('h:i A', strtotime($attend->afternoon_in));
            $row[] = empty($attend->afternoon_out) ? null : date('h:i A', strtotime($attend->afternoon_out));
            $row[] = '
                 <div class="form-button-action">
                    <a type="button" href="' . $attend->fb . '" data-toggle="tooltip" class="btn btn-link btn-primary mt-1 p-1" data-original-title="Facebook URL" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a type="button" href="#editAttendance" data-toggle="modal" class="btn btn-link btn-success mt-1 p-1" title="Edit Attendance" data-id="' . $attend->id . '" onclick="editAttendance(this)">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a type="button" href="' . site_url("attendance/delete/" . $attend->id) . '" data-toggle="tooltip" onclick="return confirm(&quot;Are you sure you want to delete this attendance?&quot);" class="btn btn-link btn-danger mt-1 p-1" data-original-title="Remove">
                        <i class="fa fa-times"></i>
                    </a>
                </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->attendanceModel->count_all($date),
            "recordsFiltered" => $this->attendanceModel->count_filtered($date),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create()
    {
        $this->session->set_flashdata('success', 'danger');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('personnel', 'Personnel', 'trim|required');
        $this->form_validation->set_rules('morning_in', 'Morning In', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', validation_errors());
        } else {

            $data = array(
                'date' => $this->input->post('date'),
                'email' => $this->input->post('personnel'),
                'morning_in' => $this->input->post('morning_in'),
                'morning_out' => $this->input->post('morning_out'),
                'afternoon_in' => $this->input->post('afternoon_in'),
                'afternoon_out' => $this->input->post('afternoon_out'),
            );

            $insert =  $this->attendanceModel->save($data);

            if ($insert) {
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'Attendance has been created!');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong. Please try again!');
            }
        }
        redirect('attendance', 'refresh');
    }

    public function generate_dtr($id = '')
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $data['person'] = $this->personnelModel->personnels($id);

        $data['title'] = 'Generate DTR';

        $data['attendance'] = $this->attendanceModel->attendance($id);

        $this->base->load('default', 'attendance/generate_dtr', $data);
    }

    public function update()
    {
        $this->session->set_flashdata('success', 'danger');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('personnel', 'Personnel', 'trim|required');
        $this->form_validation->set_rules('morning_in', 'Morning In', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message', validation_errors());
        } else {

            $id = $this->input->post('id');
            $data = array(
                'date' => $this->input->post('date'),
                'email' => $this->input->post('personnel'),
                'morning_in' => $this->input->post('morning_in'),
                'morning_out' => $this->input->post('morning_out'),
                'afternoon_in' => $this->input->post('afternoon_in'),
                'afternoon_out' => $this->input->post('afternoon_out'),
            );

            $update =  $this->attendanceModel->update($data, $id);

            if ($update) {
                $this->session->set_flashdata('success', 'success');
                $this->session->set_flashdata('message', 'Attendance has been updated!');
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
                            if ($date == date('Y-m-d', strtotime($filedata[0]))) {
                                $importRes[$i]['date'] = $filedata[0];
                                $importRes[$i]['email'] = $filedata[1];
                                $importRes[$i]['lname'] = $filedata[2];
                                $importRes[$i]['fname'] = $filedata[3];
                                $importRes[$i]['mname'] = $filedata[4];
                                $importRes[$i]['attendance'] = $filedata[6];
                                $importRes[$i]['morning_in'] = $filedata[7];
                                $importRes[$i]['morning_out'] = $filedata[8];
                                $importRes[$i]['afternoon_in'] = $filedata[9];
                                $importRes[$i]['afternoon_out'] = $filedata[10];
                            }
                        } else {
                            $importRes[$i]['date'] = $filedata[0];
                            $importRes[$i]['email'] = $filedata[1];
                            $importRes[$i]['lname'] = $filedata[2];
                            $importRes[$i]['fname'] = $filedata[3];
                            $importRes[$i]['mname'] = $filedata[4];
                            $importRes[$i]['attendance'] = $filedata[6];
                            $importRes[$i]['morning_in'] = $filedata[7];
                            $importRes[$i]['morning_out'] = $filedata[8];
                            $importRes[$i]['afternoon_in'] = $filedata[9];
                            $importRes[$i]['afternoon_out'] = $filedata[10];
                        }
                    }
                    $i++;
                }

                fclose($data);

                // Insert data
                $count = 0;
                foreach ($importRes as $data) {

                    $email = $data['email'];
                    $date = date('Y-m-d', strtotime($data['date']));
                    $attendance_type = $data['attendance'];
                    $checkAttend = $this->attendanceModel->getAttend($email, $date);

                    if (!empty($checkAttend)) {
                        if ($attendance_type == 'Morning-In') {
                            $logs = array(
                                'morning_in' => date('H:i:s', strtotime($data['morning_in']))
                            );
                            $this->attendanceModel->update($logs, $checkAttend->id);
                        } elseif ($attendance_type == 'Morning-Out') {
                            $logs = array(
                                'morning_out' => date('H:i:s', strtotime($data['morning_out']))
                            );
                            $this->attendanceModel->update($logs, $checkAttend->id);
                        } elseif ($attendance_type == 'Afternoon-In') {
                            $logs = array(
                                'afternoon_in' => date('H:i:s', strtotime($data['afternoon_in']))
                            );
                            $this->attendanceModel->update($logs, $checkAttend->id);
                        } else {
                            $logs = array(
                                'afternoon_out' => date('H:i:s', strtotime($data['afternoon_out']))
                            );
                            $this->attendanceModel->update($logs, $checkAttend->id);
                        }
                    } else {

                        if ($attendance_type == 'Morning-In') {
                            $logs = array(
                                'date' => date('Y-m-d', strtotime($data['date'])),
                                'email' => $data['email'],
                                'morning_in' => date('H:i:s', strtotime($data['morning_in']))
                            );
                            $this->attendanceModel->save($logs);
                        } elseif ($attendance_type == 'Morning-Out') {
                            $logs = array(
                                'date' => date('Y-m-d', strtotime($data['date'])),
                                'email' => $data['email'],
                                'morning_out' => date('H:i:s', strtotime($data['morning_out']))
                            );
                            $this->attendanceModel->save($logs);
                        } elseif ($attendance_type == 'Afternoon-In') {
                            $logs = array(
                                'date' => date('Y-m-d', strtotime($data['date'])),
                                'email' => $data['email'],
                                'afternoon_in' => date('H:i:s', strtotime($data['afternoon_in']))
                            );
                            $this->attendanceModel->save($logs);
                        } else {
                            $logs = array(
                                'date' => date('Y-m-d', strtotime($data['date'])),
                                'email' => $data['email'],
                                'afternoon_out' => date('H:i:s', strtotime($data['afternoon_out']))
                            );
                            $this->attendanceModel->save($logs);
                        }
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

    public function getAttendance()
    {
        $validator = array('data' => array());

        $id = $this->input->post('id');

        $validator['data'] = $this->attendanceModel->getAttendance($id);

        echo json_encode($validator);
    }

    public function delete($id)
    {

        $delete = $this->attendanceModel->delete($id);
        $this->session->set_flashdata('success', 'danger');

        if ($delete) {
            $this->session->set_flashdata('message', 'Attendance has been deleted!');
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. This borrower cannot be deleted!');
        }
        redirect('attendance', 'refresh');
    }
}
