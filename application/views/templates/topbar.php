<?php
$user = $this->ion_auth->user()->row();
$query = $this->db->query("SELECT * FROM systems WHERE id=1");
$sys = $query->row();
?>
<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark2">

        <a href="<?= site_url('admin/dashboard') ?>" class="logo">
            <img src="<?= $sys->system_logo ? site_url('assets/uploads/') . $sys->system_logo : site_url('assets/img/logo.png') ?>" alt="navbar brand" class="navbar-brand" width="40">
            <span class="text-light ml-2 fw-bold" style="font-size:20px">
                <?= $sys->system_acronym ?>
            </span>
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">

        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="icon-settings"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <?php if (empty($user->avatar)) : ?>
                                            <img src="<?= site_url() ?>assets/img/person.png" alt="image profile" class="avatar-img rounded">
                                        <?php else : ?>
                                            <img alt="preview" src="<?= preg_match('/data:image/i', $user->avatar) ? $user->avatar : site_url() . 'assets/uploads/avatar/' . $user->avatar ?>" class="avatar-img rounded" />
                                        <?php endif ?>

                                    </div>
                                    <div class="u-text">
                                        <h4><?= $user->first_name . ' ' . $user->last_name ?></h4>
                                        <p class="text-muted"><?= $user->email ?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url('auth/user_profile/') . $user->id ?>">Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Logout</a>
                            </li>
                        </div>
                    </ul>
                </li>
                <!-- <li class="nav-item dropdown hidden-caret" data-original-title="Visit Website" data-toggle="tooltip">
                    <a class="nav-link" href="<?= site_url() ?>" aria-expanded="false">
                        <i class="icon-globe"></i>
                    </a>
                </li> -->
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>