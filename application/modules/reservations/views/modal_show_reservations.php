<script>
    $(function () {
        // Display the create invoice modal
        $('#modal-show-reservations').modal('show');

        $(".simple-select").select2();

        var calcHeight = function() {

           $('#preview-frame').height($(window).height()-100);
         }

         $(document).ready(function() {
           calcHeight();
         });

         $(window).resize(function() {
           calcHeight();
         }).load(function() {
           calcHeight();
         });
    });
</script>

<div id="modal-show-reservations" class="modal col-xs-12 col-sm-12 col-sm-offset-1"
     role="dialog" aria-labelledby="modal-show-reservations" aria-hidden="true">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('show reservations'); ?></h4>
        </div>
        <div class="modal-body">


           <iframe id="preview-frame" src="<?php echo site_url()?>/reservations/index" name="preview-frame" frameborder="0" width="100%" noresize="noresize" style="height: 802px;">
           </iframe>

        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button class="select-items-confirm btn btn-success" type="button">
                    <i class="fa fa-check"></i>
                    <?php _trans('submit'); ?>
                </button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>
</div>
</div>
