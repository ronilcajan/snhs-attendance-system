<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="msg"></div>
                <form method="POST" action="<?= site_url('auth/createUser') ?>" enctype="multipart/form-data" id="create_user_form">
                    <input type="hidden" name="size" value="1000000">
                    <div class="form-group form-floating-label">
                        <label>Username</label>
                        <input type="text" class="form-control" name="identity" required minlength="5">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>User Role</label>
                        <select class="form-control" name="group" required>
                            <?php foreach ($this->ion_auth->groups()->result() as $row) : ?>
                                <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control mb-0" required="" minlength="6">
                            <div class="show-password" style="cursor:pointer">
                                <small>Show Password</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="position-relative">
                            <input id="confirmpassword" name="confirmpassword" type="password" class="form-control" required="" minlength="6">
                            <div class="show-password" style="cursor:pointer">
                                <small>Show Password</small>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>