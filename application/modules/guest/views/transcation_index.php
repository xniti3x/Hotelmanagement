<div id="headerbar">
    <div class="headerbar-item pull-left">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('guest/banking/index/all/').$this->mdl_bank_api->getValue('ckey'); ?>"
               class="btn  <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
            <a href="<?php echo site_url('guest/banking/index/notdone/').$this->mdl_bank_api->getValue('ckey'); ?>"
               class="btn  <?php echo $status == 'notdone' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('open'); ?>
            </a>
            <a href="<?php echo site_url('guest/banking/index/done/').$this->mdl_bank_api->getValue('ckey'); ?>"
               class="btn  <?php echo $status == 'done' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('Erledigt'); ?>
            </a>
            
        </div>
    </div>
</div>
<?php if(isset($_SESSION['alert_success'])) {echo("<div style='color:green;'>".$_SESSION['alert_success']."</div>");} ?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
  <thead>
    <tr>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php

  foreach($transactions as $transaction){
    $amount=$transaction['transactionAmount'];
    $title=$transaction['title'];
    if(isset( $transaction['remittanceInformationStructured'] ) ){
    $note=$transaction['remittanceInformationStructured'];
    }
    if($amount<0){ $color="red";}else{$color="green";}
    $title="<b>".$title." - ".$transaction['bookingDate']."</b><p>".$note."<br>".$transaction['additionalInformation']." <b style='color:".$color.";'>".$amount."€</b></p>";
   echo "<tr>
   <td>".$title."<p><a class='btn btn-default btn-xs' href='".site_url('guest/banking/view/'.$this->mdl_bank_api->getValue('ckey').'/'.$transaction['transactionId'])."'>Bearbeiten</a></p></td>
   </tr>";
  }
?>
  </tbody>
</table>
<div>