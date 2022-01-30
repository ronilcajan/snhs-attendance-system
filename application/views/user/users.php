<div class="page-header">
    <h4 class="page-title">Users Management</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="#">
                <i class="fas fa-cogs"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)">Settings</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)">Users</a>
        </li>
    </ul>
    <div class="ml-md-auto py-2 py-md-0">
        <a href="#addUser" data-toggle="modal" class="btn btn-secondary btn-round text-light">Add User</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">System Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Group</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($users as $user):?>
                            <tr>
                                <td><?= htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8').' '.htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8')?></td>
                                <td><?= htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                                <td>
                                    <?php foreach ($user->groups as $group):?>
                                        <?= htmlspecialchars($group->name,ENT_QUOTES,'UTF-8') ;?><br />
                                    <?php endforeach?>
                                </td>
                                <td>
                                    <div class="form-button-action">
                                        <a type="button" href="<?= site_url("auth/delete_user/".$user->id) ;?>" data-toggle="tooltip" 
                                            onclick="return confirm('Are you sure you want to delete this user?');" 
                                            class="btn btn-link btn-danger mt-1" data-original-title="Remove">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('user/modal') ?>