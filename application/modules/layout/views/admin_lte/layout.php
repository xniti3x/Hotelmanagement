<!DOCTYPE html>
<html lang="en">

<?php $this->layout->load_view("layout/admin_lte/head"); ?>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
    <div class="wrapper">


    <?php $this->layout->load_view("layout/admin_lte/navbar"); ?>

        
    <?php $this->layout->load_view("layout/admin_lte/sidebar"); ?>

        <div class="content-wrapper">
            
    <?php echo $this->layout->load_view('layout/includes/fullpage-loader'); ?>

    <div id="modal-placeholder"></div>
    
            <div class="content">
                <div class="container-fluid">
                <?php echo $content; ?>
                </div>

            </div>

        </div>

            
        <aside class="control-sidebar control-sidebar-dark">

        </aside>


        <footer class="main-footer">

        </footer>
    </div>

<?php if (trans('cldr') != 'en') { ?>
    <script src="<?php _core_asset('js/locales/select2/' . trans('cldr') . '.js'); ?>"></script>
<?php } ?>

    <!--<script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script> -->

    <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/AdminLTE/dist/js/adminlte.js?v=3.2.0"></script>

    <!-- <script src="<?php echo base_url(); ?>assets/AdminLTE/plugins/chart.js/Chart.min.js"></script> -->

    <script src="<?php echo base_url(); ?>assets/AdminLTE/dist/js/demo.js"></script>

    <!-- <script src="<?php echo base_url(); ?>assets/AdminLTE/dist/js/pages/dashboard3.js"></script> -->

    
</body>

</html>