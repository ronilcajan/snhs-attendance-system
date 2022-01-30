<?php
$query = $this->db->query("SELECT * FROM systems WHERE id=1");
$sys = $query->row();
?>
<!-- Modal -->
<div class="modal fade" id="restore" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Restore Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url('settings/restore') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div class="form-group form-floating-label">
                        <label>Upload Sql file</label>
                        <input type="file" class="form-control" accept=".sql" name="backup_file" required>
                    </div>
                    <small class="form-text text-muted">Note: pls upload sql file only.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Restore</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="sett" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Systems</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url('settings/save_settings') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div class="form-group form-floating-label">
                        <label>Upload System Logo</label>
                        <input type="file" class="form-control" accept="image/*" name="sys_logo">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>System Name</label>
                        <input type="text" class="form-control" name="sys_name" value="<?= $sys->system_name ?>">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>System Acronym</label>
                        <input type="text" class="form-control" name="sys_acronym" value="<?= $sys->system_acronym ?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>