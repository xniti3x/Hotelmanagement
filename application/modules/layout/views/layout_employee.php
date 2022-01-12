<!DOCTYPE html>

<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="<?php _trans('cldr'); ?>"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="<?php _trans('cldr'); ?>"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="<?php _trans('cldr'); ?>"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="<?php _trans('cldr'); ?>"> <!--<![endif]-->
<head>
    <title>
        <?php
        if (get_setting('custom_title') != '') {
            echo get_setting('custom_title', '', true);
        } ?>
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="NOINDEX,NOFOLLOW">
    <meta name="_csrf" content="<?php echo $this->security->get_csrf_hash() ?>">

    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/core/img/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom.css">
    <link href='<?php echo base_url(); ?>/node_modules/fullcalendar/main.css' rel='stylesheet' />
    
    <script src="<?php echo base_url(); ?>assets/core/js/dependencies.min.js"></script>
    <script src='<?php echo base_url(); ?>/node_modules/fullcalendar/main.js'></script>
    <script src='<?php echo base_url(); ?>/node_modules/fullcalendar/locales/de.js'></script>
    <script><?php $this->layout->load_view('employee/fullcalendar.js'); ?></script>
    <script><?php $this->layout->load_view('employee/jquery-toast.js'); ?></script>
    <script src="https://unpkg.com/emodal@1.2.69/dist/eModal.min.js"></script>
</head>
<body class="hidden-sidebar">
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle"
                    data-toggle="collapse" data-target="#ip-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <?php echo trans('menu') ?> &nbsp; <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="ip-navbar-collapse">
            <ul class="nav navbar-nav">
            <!-- <li><?php echo anchor('employee/index', trans('dashboard')); ?></li> -->
            <li><?php echo anchor('employee/timesheet', trans('timesheet')); ?></li>
            </ul>
            <ul class="nav navbar-nav navbar-right settings">
                <li>
                    <a href="<?php echo site_url('sessions/logout'); ?>"
                       class="tip icon logout" data-placement="bottom"
                       title="<?php _trans('logout'); ?>">
                        <span class="visible-xs">&nbsp;<?php _trans('logout'); ?></span>
                        <i class="fa fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="main-area">
    <div id="main-content">
        <?php echo $content; ?>
    </div>
</body>
</html>