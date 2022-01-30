<?php
$user = $this->ion_auth->user()->row();
$gro = $this->ion_auth->get_users_groups()->row();
?>
<h4 class="page-title"><?= $title ?></h4>
<div class="row">
    <div class="col-md-8">
        <div class="card card-with-nav">
            <div class="card-header">
                <div class="row row-nav-line">
                    <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-3" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="true">Profile</a> </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= site_url(uri_string()) ?>" enctype="multipart/form-data" id="update_user_form">
                    <input type="hidden" name="size" value="1000000">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div id="my_camera" style="height: 250;" class="text-center">
                                <?php if (empty($user->avatar)) : ?>
                                    <img class="img img-fluid" width="250" alt="preview" src="<?= site_url() ?>assets/img/person.png" />
                                <?php else : ?>
                                    <img class="img img-fluid" width="250" alt="preview" src="<?= preg_match('/data:image/i', $user->avatar) ? $user->avatar : site_url() . 'assets/uploads/avatar/' . $user->avatar ?>" />
                                <?php endif ?>

                                <!-- <img src="<?= site_url() ?>/assets/uploads/avatar/<?= $user->avatar ?>" alt="..." class="img img-fluid" width="250" alt="preview"> -->
                            </div>
                            <!-- <div class="form-group d-flex justify-content-center">
                            <button type="button" class="btn btn-danger btn-sm mr-2" id="open_cam">Open Camera</button>
                            <button type="button" class="btn btn-secondary btn-sm ml-2" onclick="save_photo()">Capture</button>   
                        </div> -->
                            <div id="profileImage">
                                <input type="hidden" name="profileimg">
                            </div>
                            <div class="form-group form-group-default">
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?= $user->first_name ?>">
                            </div>
                            <div class="form-group form-group-default">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?= $user->last_name ?>">
                            </div>
                            <div class="mb-3">
                                <div class="form-group form-group-default mb-0">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" value="">
                                </div>
                                <div class="show-password mt-0" style="cursor:pointer">
                                    <small>Show Password</small>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-group form-group-default mb-0">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirm" value="">
                                </div>
                                <div class="show-password mt-0" style="cursor:pointer">
                                    <small>Show Password</small>
                                </div>
                            </div>
                            <?php if ($this->ion_auth->is_admin()) : ?>
                                <h4><?php echo lang('edit_user_groups_heading'); ?></h4>
                                <?php foreach ($groups as $group) : ?>
                                    <label class="checkbox">
                                        <input type="radio" name="groups[]" value="<?php echo $group['id']; ?>" <?php echo (in_array($group, $currentGroups)) ? 'checked="checked"' : null; ?>>
                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php echo form_hidden('id', $user->id); ?>
                    <?php echo form_hidden($csrf); ?>
                    <div class="text-right mt-3 mb-3">
                        <input type="hidden" class="form-control" name="id" value="<?= $user->id ?>">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-profile">
            <div class="card-header" style="background-image: url('<?= site_url() ?>/assets/img/blogpost.jpg')">
                <div class="profile-picture">
                    <div class="avatar avatar-xl">
                        <?php if (empty($user->avatar)) : ?>
                            <img class="avatar-img rounded-circle" alt="preview" src="<?= site_url() ?>assets/img/person.png" />
                        <?php else : ?>
                            <img class="avatar-img rounded-circle" alt="preview" src="<?= preg_match('/data:image/i', $user->avatar) ? $user->avatar : site_url() . 'assets/uploads/avatar/' . $user->avatar ?>" />
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="user-profile text-center">
                    <div class="name"><?= $user->first_name . ' ' . $user->last_name ?></div>
                    <div class="job"><?= $gro->name ?></div>
                    <div class="desc"><?= $user->email ?></div>
                </div>
            </div>
        </div>
    </div>
</div>