<!-- Modal -->
<div class="modal fade" id="addAttendance" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url('attendance/create') ?>">
                    <div class="form-group form-floating-label">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Select Personnel</label>
                        <select class="form-control" name="personnel" id="basic" style="width:100%;" required>
                            <optgroup label="SNHS Personnel">
                                <?php foreach ($person as $row) : ?>
                                    <option value="<?= $row->email ?>"><?= $row->lastname . ', ' . $row->firstname . ' ' . $row->middlename ?></option>
                                <?php endforeach ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Morning In</label>
                        <input type="time" class="form-control" name="morning_in" value="07:30" required>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Morning Out</label>
                        <input type="time" class="form-control" name="morning_out" value="12:00">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Afternoon In</label>
                        <input type="time" class="form-control" name="afternoon_in" value="12:30">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Afternoon Out</label>
                        <input type="time" class="form-control" name="afternoon_out" value="16:30">
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

<!-- Modal -->
<div class="modal fade" id="editAttendance" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url('attendance/update') ?>">
                    <div class="form-group form-floating-label">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" value="<?= date('Y-m-d') ?>" required id="date">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Select Personnel</label>
                        <select class="form-control" name="personnel" id="basic2" style="width:100%;" required>
                            <optgroup label="SNHS Personnel">
                                <?php foreach ($person as $row) : ?>
                                    <option value="<?= $row->email ?>"><?= $row->lastname . ', ' . $row->firstname . ' ' . $row->middlename ?></option>
                                <?php endforeach ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Morning In</label>
                        <input type="time" class="form-control" name="morning_in" value="07:30" required id="morning_in">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Morning Out</label>
                        <input type="time" class="form-control" name="morning_out" id="morning_out">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Afternoon In</label>
                        <input type="time" class="form-control" name="afternoon_in" id="afternoon_in">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Afternoon Out</label>
                        <input type="time" class="form-control" name="afternoon_out" id="afternoon_out">
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="attendance_id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= site_url('attendance/importCSV') ?>" enctype="multipart/form-data">
                    <div class="form-group form-floating-label">
                        <label>Select Date</label>
                        <input type="date" class="form-control" name="from" id="from_date">
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Upload CSV</label>
                        <input type="file" class="form-control" name="import_file" accept=".csv" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="importCSV">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>