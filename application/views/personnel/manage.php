<div class="page-header">
    <h4 class="page-title"><?= $title ?></h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="#">
                <i class="fas fa-users"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)">Personnel</a>
        </li>
    </ul>
    <div class="ml-md-auto py-2 py-md-0">
        <a href="#import" data-toggle="modal" class="btn btn-danger btn-border btn-round btn-sm">
            <span class="btn-label">
                <i class="fas fa-file-import"></i>
            </span>
            Import Pesonnel
        </a>
        <a href="#add" data-toggle="modal" class="btn btn-primary btn-border btn-round btn-sm">
            <span class="btn-label">
                <i class="far fa-address-book"></i>
            </span>
            Add Pesonnel
        </a>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List of Personnel</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="personnelTable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Fullname</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Biometrics ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Full name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Biometrics ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1;
                            foreach ($person as $row) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><a href="<?= site_url('admin/personnel_attendace/') . $row->id ?>"><?= htmlspecialchars($row->lastname, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($row->firstname, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row->middlename, ENT_QUOTES, 'UTF-8') ?></a></td>
                                    <td><?= htmlspecialchars($row->position, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><a href="mailto:<?= htmlspecialchars($row->email, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($row->email, ENT_QUOTES, 'UTF-8'); ?></a></td>
                                    <td><?= $row->bio_id ?></td>
                                    <td><?= $row->status == 1 ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
                                    <td>
                                        <div class="form-button-action">
                                            <?php if ($row->fb) : ?>
                                                <a type="button" href="<?= $row->fb ?>" data-toggle="tooltip" class="btn btn-link btn-primary mt-1 p-1" data-original-title="Facebook URL" target="_blank">
                                                    <i class="fab fa-facebook"></i>
                                                </a>
                                            <?php endif ?>
                                            <a type="button" href="#edit" data-toggle="modal" class="btn btn-link btn-success mt-1 p-1" title="Edit Personnel" data-id="<?= $row->id ?>" onclick="editPersonnel(this)">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a type="button" href="<?= site_url('admin/generate_dtr/') . $row->id ?>" class="btn btn-link btn-secondary mt-1 p-1" title="Generate DTR" data-id="<?= $row->id ?>" onclick="editPersonnel(this)">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            <a type="button" href="<?= site_url("personnel/delete/" . $row->id); ?>" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this personnel?');" class="btn btn-link btn-danger mt-1 p-1" data-original-title="Remove">
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
</div>

<?php $this->load->view('personnel/modal') ?>