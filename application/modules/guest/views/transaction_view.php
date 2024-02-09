<?php if(isset($_SESSION['alert_error'])) {echo("<div style='color:red;'>".$_SESSION['alert_error']."</div>");} ?>
<br>
<div class="panel panel-default">
  <div class="panel-heading">
    
<a class="btn btn-default btn-xs" href="<?php echo site_url("guest/banking/index/all/".$this->mdl_bank_api->getValue('ckey')) ?>"> zurück </a>
  <?php echo "<b>".$transaction["title"]."</b>"; ?></div>
  <div class="panel-body">
  <table class="table table-hover">
    <?php 
    $color= $transaction["transactionAmount"] <0?"red":"green";
    echo 
    "<tr><td>".$transaction["bookingDate"]."</td></tr>".
    "<tr><td>".$transaction["valueDate"]."</td></tr>".
    "<tr><td style='color:".$color.";'><b>".$transaction["transactionAmount"]."€</b></td></tr>".
    "<tr><td>".$transaction["iban"]."</td></tr>".
    "<tr><td>".$transaction["remittanceInformationStructured"]."</td></tr>".
    "<tr><td>".$transaction["additionalInformation"]."</td></tr>";
    ?>    
  </table>
  </div>
</div>
<br>
<div class="panel panel-default">
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-hover table-striped">
  <tbody>
  <?php
  //print_r($trans);
  foreach($transfiles as $tran){
    $str=$tran->full_path;
  echo "<tr><td><a target='_blank' href='".base_url().substr($str,strpos($str, 'uploads/'))."'>".$tran->file_name."</a></td><td></td></tr>";
  }
  ?>
  </tbody>
  </table>
  </div>
  </div>
</div>