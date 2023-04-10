<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <img src="<?php echo base_url(); ?>assets/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url(); ?>assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo site_url("dashboard/index"); ?>" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p><?php echo trans('dashboard'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa fa-users"></i>
                        <p>
                        <?php _trans('clients'); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="<?php echo site_url('clients/index'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('view_clients'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('clients/form'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('add_client'); ?></p>
                            </a>
                        </li>
                    </ul>
                    
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                        <?php _trans('invoices'); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item"> 
                            <a href="<?php echo site_url('invoices/status/all'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('view_invoices'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="create-invoice nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('create_invoice'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('invoices/recurring/index'); ?>" class="create-invoice nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('view_recurring_invoices'); ?></p>
                            </a>
                        </li>
                    </ul>
                    
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url("invoices/status/reservation"); ?>" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p><?php echo trans('view_reservations'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                        <?php _trans('payments'); ?>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item"> 
                            <a href="<?php echo site_url('payments/form'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('enter_payment'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('payments/index'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('view_payments'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('payments/online_logs'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('view_payment_logs'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('banking/index'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo trans('bank_statement'); ?></p>
                            </a>
                        </li>
                    </ul>
                    
                </li>
            </ul>
        </nav>

    </div>

</aside>