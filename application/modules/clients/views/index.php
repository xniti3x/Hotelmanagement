
<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('clients/partial_client_table'); ?>
    </div>

</div>


<!-- loads datatable js files -->
<?php $this->load->view("layout/admin_lte/datatablelib");