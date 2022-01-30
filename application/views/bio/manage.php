<div class="page-header">
    <h4 class="page-title"><?= $title ?></h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="#">
                <i class="fas fa-fingerprint"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)">Biometrics</a>
        </li>
    </ul>
    <div class="ml-md-auto py-2 py-md-0">
        <a href="#import" data-toggle="modal" class="btn btn-danger btn-border btn-round btn-sm">
            <span class="btn-label">
                <i class="fas fa-file-import"></i>
            </span>
            Import Biometrics
        </a>
        <a href="<?= site_url('admin/generate_bio') ?>" class="btn btn-secondary btn-border btn-round btn-sm">
            <span class="btn-label">
                <i class="fas fa-layer-group"></i>
            </span>
            Generate Biometrics Report
        </a>
        <a href="#addAttendance" data-toggle="modal" class="btn btn-primary btn-border btn-round btn-sm">
            <span class="btn-label">
                <i class="far fa-clock"></i>
            </span>
            Create Attendance
        </a>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Personnel Attendance</div>
                    <div class="card-tools">
                        <input type="month" class="form-control" id="month" name="start" min="2021-01" value="<?= isset($_GET['date']) ? $_GET['date'] : date('Y-m') ?>">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="bioTable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Personnel</th>
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
                                <th>Personnel</th>
                                <th>Morning-In</th>
                                <th>Morning-Out</th>
                                <th>Afternoon-In</th>
                                <th>Afternoon-Out</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('bio/modal') ?>