<h4 class="page-title">User Profile</h4>
<div class="row">
    <div class="col-md-8">
        <div class="card card-with-nav">
            <div class="card-header">
                <div class="row row-nav-line">
                    <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="true">My Attendance</a> </li>
                        <li class="nav-item mt-2">
                            <div class="card-tools">
                                <input type="month" class="form-control" id="month" name="start" min="2021-01" value="<?= isset($_GET['date']) ? $_GET['date'] : date('Y-m') ?>">
                            </div>
                        </li>

                    </ul>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="attendanceTable1" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Morning-In</th>
                                <th>Morning-Out</th>
                                <th>Afternoon-In</th>
                                <th>Afternoon-Out</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Morning-In</th>
                                <th>Morning-Out</th>
                                <th>Afternoon-In</th>
                                <th>Afternoon-Out</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1;
                            foreach ($attendance as $row) : ?>
                                <tr>
                                    <td><?= date('m/d/Y', strtotime($row->date)) ?></td>
                                    <td><?= empty($row->morning_in) ? null : date('h:i A', strtotime($row->morning_in))  ?></td>
                                    <td><?= empty($row->morning_out) ? null : date('h:i A', strtotime($row->morning_out)) ?></td>
                                    <td><?= empty($row->afternoon_in) ? null : date('h:i A', strtotime($row->afternoon_in)) ?></td>
                                    <td><?= empty($row->afternoon_out) ? null : date('h:i A', strtotime($row->afternoon_out)) ?></td>
                                    <td>
                                        <div class="form-button-action">
                                            <a type="button" href="<?= $row->fb ?>" data-toggle="tooltip" class="btn btn-link btn-primary mt-1 p-1" data-original-title="Facebook URL" target="_blank">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                            <a type="button" href="#editAttendance" data-toggle="modal" class="btn btn-link btn-success mt-1 p-1" title="Edit Attendance" data-id="<?= $row->id ?>" onclick="editAttendance(this)">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a type="button" href="<?= site_url("attendance/delete/" . $row->id); ?>" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this attendance?');" class="btn btn-link btn-danger mt-1 p-1" data-original-title="Remove">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-profile">
            <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                <div class="profile-picture">
                    <div class="avatar avatar-xl">
                        <img src="<?= site_url() ?>assets/img/person.png" alt="..." class="avatar-img rounded-circle">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="user-profile text-center">
                    <div class="name"><?= htmlspecialchars($person->lastname, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($person->firstname, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($person->middlename, ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="job"><?= $person->position ?></div>
                    <div class="desc"><?= $person->role ?></div>
                    <div class="social-media">
                        <a class="btn btn-info btn-twitter btn-sm btn-link" href="<?= site_url('admin/generate_dtr/') . $id ?>">
                            <span class="btn-label just-icon"><i class="flaticon-file"></i> </span>
                        </a>
                        <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="mailto:<?= $person->email ?>">
                            <span class="btn-label just-icon"><i class="flaticon-envelope-1"></i> </span>
                        </a>
                        <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="<?= $person->fb ?>" target="_blank">
                            <span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- <div class="card-footer">
                <div class="row user-stats text-center">
                    <div class="col">
                        <div class="number">125</div>
                        <div class="title">Post</div>
                    </div>
                    <div class="col">
                        <div class="number">25K</div>
                        <div class="title">Followers</div>
                    </div>
                    <div class="col">
                        <div class="number">134</div>
                        <div class="title">Following</div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<?php $this->load->view('attendance/modal') ?>