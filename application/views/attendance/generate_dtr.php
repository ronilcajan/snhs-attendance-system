<div class="page-header">
    <h4 class="page-title"><?= $title ?></h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="#">
                <i class="fas fa-calendar-check"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="javascript:void(0)">Attendance</a>
        </li>
    </ul>
    <div class="ml-md-auto py-2 py-md-0">
        <a href="javascript:void(0)" class="btn btn-danger btn-border btn-round btn-sm" onclick="printDiv('printThis')" title="Print DTR">
            <span class=" btn-label">
                <i class="fa fa-print"></i>
            </span>
            Print
        </a>
        <a href="<?= site_url('admin/generate_dtr') ?>" class="btn btn-primary btn-border btn-round btn-sm" title="Refresh">
            <span class=" btn-label">
                <i class="icon-refresh"></i>
            </span>
            Refresh
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Personnel WFH Time Record</div>
                    <div class="card-tools">
                        <input type="month" class="form-control" id="month" name="start" min="2021-01" value="<?= isset($_GET['date']) ? $_GET['date'] : date('Y-m') ?>">
                    </div>
                </div>

            </div>
            <div class="card-body text-center" id="printThis">
                <?php $a = 1;
                foreach ($person as $row) : ?>
                    <div style="display: inline-block; margin-right:20px; border: 1px solid gray; padding:20px">
                        <?php
                        $email = $row->email;
                        if (isset($_GET['date'])) {
                            $date = $_GET['date'];
                            $month = date('m', strtotime($date));
                            $year = date('Y', strtotime($date));
                            $query = $this->db->query("SELECT * FROM attendance WHERE email='$email' AND MONTH(date)=$month AND YEAR(date)=$year ORDER BY attendance.date ASC");
                        } else {
                            $query = $this->db->query("SELECT * FROM attendance WHERE email='$email' AND MONTH(date) = MONTH(CURRENT_DATE())
                                        AND YEAR(date) = YEAR(CURRENT_DATE()) ORDER BY attendance.date ASC");
                        }
                        $time = $query->result();
                        ?>
                        <table class="w-100 table-bordered">
                            <thead>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" class="text-center">WFH Time Record</th>
                                </tr>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" class="text-center">SINONOC NATIONAL HIGH SCHOOL</th>
                                </tr>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" style="height: 20px;"> </th>
                                </tr>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" class="text-center">
                                        <u><?= !empty($row->middlename[0]) ? $row->firstname . ' ' . $row->middlename[0] . '. ' . $row->lastname : $row->firstname . ' ' . $row->lastname  ?></u>
                                    </th>
                                </tr>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" class="text-center">
                                        Name
                                    </th>
                                </tr>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" style="height: 20px;"> </th>
                                </tr>
                                <tr style="border-style:hidden;">
                                    <th colspan="5" class="text-center">For the Month of <u><?= isset($date) ? date('F', strtotime($date)) : date('F') ?></u>,<u><?= isset($date) ? date('Y', strtotime($date)) : date('Y') ?></u></th>
                                </tr>
                                <tr>
                                    <th colspan="5"> </th>
                                </tr>
                                <tr>
                                    <th colspan="5" style="height: 10px;"> </th>
                                </tr>
                                <tr style="border-left:none;">
                                    <th colspan="5"> </th>
                                </tr>
                                <tr>
                                    <th class="p-1">Day</th>
                                    <th class="p-1">Morning In</th>
                                    <th class="p-1">Morning Out</th>
                                    <th class="p-1">Afternoon In</th>
                                    <th class="p-1">Afternoon Out</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $b = 0;
                                for ($i = 1; $i <= date("t"); $i++) :
                                    if (!empty($time[$b]->date)) :
                                        if (date('j', strtotime($time[$b]->date)) == $i) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= !empty($time[$b]->morning_in) ? date('h:i A', strtotime($time[$b]->morning_in)) : null ?></td>
                                                <td><?= !empty($time[$b]->morning_out) ? date('h:i A', strtotime($time[$b]->morning_out)) : null ?></td>
                                                <td><?= !empty($time[$b]->afternoon_in) ? date('h:i A', strtotime($time[$b]->afternoon_in)) : null ?></td>
                                                <td><?= !empty($time[$b]->afternoon_out) ? date('h:i A', strtotime($time[$b]->afternoon_out)) : null ?></td>
                                            </tr>
                                        <?php $b++;
                                        else : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php endif ?>

                                <?php endfor ?>
                            </tbody>
                        </table>
                        <small class="text-muted text-center" style="font-size: 9px;"><i>Generated thru Time Record System</i></small>
                    </div>

                    <?php if ($a % 2 == 0) : ?>
                        <div class="print-break clearfix" style='overflow:hidden;page-break-before:always;'></div>
                    <?php endif ?>
                <?php $a++;
                endforeach ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('attendance/modal') ?>