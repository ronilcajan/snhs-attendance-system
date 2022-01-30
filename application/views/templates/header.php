<?php
$query = $this->db->query("SELECT * FROM systems WHERE id=1");
$sys = $query->row();
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?= $title ?> | <?= $sys->system_name ?></title>
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="<?= site_url() ?>assets/img/icon.ico" type="image/x-icon" />

<!-- Fonts and icons -->
<script src="<?= site_url() ?>assets/js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
            urls: ['<?= site_url() ?>assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="<?= site_url() ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= site_url() ?>assets/css/atlantis.css">
<link rel="stylesheet" href="<?= site_url() ?>assets/css/custom.css">